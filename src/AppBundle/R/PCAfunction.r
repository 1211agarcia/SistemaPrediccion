#pca: componente principal a graficar
#n: limite de comp a grafica
#j desde donde se iniciara la graifcacion
graf<-function(pca,j,n)
{
	par(mfrow=c(n-j+1,1))
	for(i in j:n)
	{
		plot(-1*loadings(pca)[,i],type="h",col="blue",ylab=paste("Componente",i),xaxt = "n")
		abline(h=0)
		axis(1, at = 1:nrow(loadings(pca)),
			labels = rownames(loadings(pca)))
	}
}
graf1<-function(pca)
{
	plot(pca$sdev^2,ylab=expression(lambda),xaxt="n",pch=21,bg="blue",xlab="Componentes")
	axis(1, at = 1:ncol(loadings(pca)),
		labels = colnames(loadings(pca)))
	abline(h=mean(pca$sdev^2),col="red")
}

#Articulo
norma<-function(x)
{
	if(ncol(x)==1||is.null(ncol(x)))
	{
		x<-matrix(x,nrow=1)
		sal<-sqrt(x%*%t(x))
		return(sal)
	}
	sal<-sqrt(x%*%t(x))
	sal<-sal[col(sal)==row(sal)]
	return(sal)
}
funcion1<-function(Patrones)
{
	SIGMA<-Patrones
	A<-SIGMA-rowMeans(SIGMA)
	v1<-eigen(t(A)%*%A)$vectors
	l1<-eigen(t(A)%*%A)$values
	v<-A%*%v1
	v<-qr.Q(qr(v))
	return(list(A,v,l1))
}
funcion2<-function(A,v)
{
	Omega<-NULL
	for( h in 1:ncol(A))
	{
		WW<-NULL
		for(i in 1:ncol(v))
		{
			pesodelaimagen<-v[,i]%*%A[,h] 
			WW<-c(WW,pesodelaimagen)
		}
		Omega<-cbind(Omega,WW)
	}
	return(Omega)
}
funcion3<-function(NF,v,Omega,Patrones)
{
	NFe<-NF-rowMeans(Patrones)
	WWn<-NULL
	for(i in 1:ncol(v))
	{
		pesodelaimagen<-v[,i]%*%NFe 
		WWn<-c(WWn,pesodelaimagen)
	}
	OmegaN<-WWn
	clase<-1:ncol(v)
	distancia<-dist(t(cbind(OmegaN,Omega)))[1:3]
	clase<-clase[distancia==min(distancia)]
	return(list(distancia,clase))
}

Proyeccion<-function(u,v)
{
	if((ncol(u)==1||is.null(ncol(u)))&&(ncol(v)==1||is.null(ncol(v))))
	{
		sal<-((u%*%v)/(norma(v)^2))*v
		return(sal)
	}

	if(ncol(u)==1||is.null(ncol(u)))
	{
		u<-matrix(u,nrow=1)
		sal<-as.numeric(t(u%*%t(v)/norma(v)^2))*v
		return(sal)
	}

	if(ncol(v)==1||is.null(ncol(v)))
	{
		v<-matrix(v,ncol=1)
		sal<-as.numeric((u%*%v)/as.numeric(norma(v)^2))*t(matrix(rep(v,nrow(u)),ncol=nrow(u)))
		return(sal)
	}


}
Proporcion<-function(v,A)
{
	norma(v)/sum(norma(A))
}

#Combinacion muestra optima para pca
#n = numero de iteraciones
#y = muestra total 100%
#k = el numero la muestra a seleccionar el aproximado al 30%
#c = indica el varlo de la variable cor para el PCA
PCAoptimo<-function(y, n, k, c)
{
	acum <- 0
	indices_opti <- NULL

	indice<-sample(1:nrow(y),k)
	ytrain<-y[indice,1:5]

	pr <- prcomp(ytrain, scale = TRUE,cor=c)

	for(i in 1:n){
		indice<-sample(1:nrow(y),k)
		ytrain<-y[indice,1:5]

		pr <- prcomp(ytrain, scale = TRUE,cor=c)
		vars <- apply(pr$x, 2, var)  
		props <- vars / sum(vars)

		if(cumsum(props)[1] > acum)
		{
			acum <- cumsum(props)[1]
			indices_opti <- indice
			print(cumsum(props))
		}
	}

	return(list(indices=indices_opti, acum=acum))
}

myTrain<-function(m,s,capas, P, P_v, target, claseT, p_ecm){

net1 <- newff(n.neurons=c(2,capas,2), learning.rate.global=p_ecm, momentum.global=m,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
result1 <- train(net1,P , target, error.criterium="LMS", report=TRUE, show.step=s, n.shows=5 )
s <- sim(result1$net, P)
print("Entrenando")
tasa_1<-rep(FALSE,nrow(s))
tasa_1[round(s)[,1]== target[,1] & round(s)[,2]== target[,2]]<-TRUE
tasa_1 <- sum(tasa_1==TRUE)*100/length(tasa_1)

print(tasa_1)
ECM_1 <- error.LMS(c(s,target,net1))
print(ECM_1) 

print("Validando")
s <- sim(result1$net, P_v)

tasa_2<-rep(FALSE,nrow(s))
tasa_2[round(s)[,1]== claseT[,1] & round(s)[,2]== claseT[,2]]<-TRUE
tasa_2 <- sum(tasa_2==TRUE)*100/length(tasa_2)

print(tasa_2)

ECM_2 <- error.LMS(c(s,claseT,net1))
print(ECM_2) 

#return(list(ecm_1=as.numeric(ECM_1), t_1=as.numeric(tasa_1), ecm_2=as.numeric(ECM_2), t_2=as.numeric(tasa_2)))
return(c(as.numeric(ECM_1), as.numeric(tasa_1),as.numeric(ECM_2), as.numeric(tasa_2)))
}

validacion_cruzada<-function(y, iteraciones) {
#########################################
#    Calculo de grupos de salida
#
# Conglomerado Total se asigna una etiqueta a cada caso segun su nota de calculo 1
sal <- y[,6]
sal
conglomeradoT<-rep(FALSE,length(sal))
conglomeradoT[sal<=10]<-1 #Nivel Bajo
conglomeradoT[sal>=11&sal<16]<-2 #Nivel Medio
conglomeradoT[sal>=16]<-3 #Nivel Alto

########################
#Generación de clase
########################
medias<-c(mean(data[conglomeradoT==1,7]),mean(data[conglomeradoT==2,7]),mean(data[conglomeradoT==3,7]))
medias
names(medias)<-c(1,2,3)
claseC<-as.numeric(names(sort(medias)))

trains <- NULL
trains
for(i in 1:iteraciones){
	print("------------------------------------------------")
	print(i*100/iteraciones)
	print("------------------------------------------------")
	indice <- PCAoptimo(y,1,87,F)$indices
	ytrain<-y[indice,1:5]
	ytest<-y[-indice,1:5]
	comp <-princomp(ytrain,cor=F)
	cargas<-comp$loadings[,]
	comT<-score(ytest,cargas)
	conglomerado_train<-conglomeradoT[indice]
	conglomerado_test<-conglomeradoT[-indice]

	clase<-matrix(NA, ncol=2, nrow=nrow(ytrain))
	clase[conglomerado_train==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomerado_train==claseC[1])), byrow=TRUE, ncol=2 )
	clase[conglomerado_train==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomerado_train==claseC[2])), byrow=TRUE, ncol=2 )
	clase[conglomerado_train==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomerado_train==claseC[3])), byrow=TRUE, ncol=2 )
	claseT<-matrix(NA, ncol=2, nrow=nrow(ytest))
	claseT[conglomerado_test==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomerado_test==claseC[1])), byrow=TRUE, ncol=2 )
	claseT[conglomerado_test==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomerado_test==claseC[2])), byrow=TRUE, ncol=2 )
	claseT[conglomerado_test==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomerado_test==claseC[3])), byrow=TRUE, ncol=2 )

	target<-clase
	P<-matrix(c(comp$score[,1],comp$score[,2]),ncol=2,byrow=TRUE)
	P_v <-comT[,1:2]

	trains <- matrix(rbind(trains, myTrain(0.7, 13, c(2,2), P, P_v, clase,claseT, 0.1)), byrow=FALSE, ncol=4 )
}
return (trains)

}

score<-function(y,carga)
{
yc<-y-matrix(rep(colMeans(y),nrow(y)),ncol=ncol(y),byrow=TRUE)
salida<-as.matrix(yc)%*%carga
return(salida)
}
