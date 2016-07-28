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
			print(acum)
		}
	}

	return(list(indices=indices_opti, acum=acum))
}

circunferencia<-function(centro=c(0,0),radio=1){

if(radio<=0) stop("El radio de una circunferencia es estrictamente positivo")
if(length(centro)!=2) stop("El centro de una circunferencia en el plano debe ser un vector de dimensión 2")

xmin<-centro[1]-radio
xmax<-centro[1]+radio
ymin<-centro[2]-radio
ymax<-centro[2]+radio


x1<-seq(xmin,xmax,0.01)
x2<-seq(xmax,xmin,-0.01)
xx<-c(x1,x2)

y1<-centro[2]+sqrt(radio^2-(x1-centro[1])^2)
y2<-centro[2]-sqrt(radio^2-(x2-centro[1])^2)
yy<-c(y1,y2)

plot(xx,yy,type="l")

}


