##########################################################
# PCA con variables CONTINUAS
#########################################################

source("PCAfunction.r")
graphics.off()
library(rgl)
library(AMORE)
#########################
#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("muestra_estudiantes.txt",header=TRUE)
data
#Nombre de columnas a ignorar para este experimento, calclulo de ignora pues es la salida deseada
drops <- c("cant_mat","escuela","gestion_plantel","tipo_plantel","nivel_socioeco","nivel_estudios_padres","genero","opsu")

y <- data[ , !(names(data) %in% drops)]
y
cor(y[ , 1:5])
cor(y)

#De la muestra total se busca la combinacion con mejor ajuste para el PCA
#Me intera 1000000 de veces para combincaciones de 87 casos
aux <-PCAoptimo(y,10,87,F)
#aux
#names(aux)
#Se realiza el Analisis de de Componentes Principales usando la matriz de Covarianza #
#indice<-sample(1:nrow(y),87)
# teniendo la mejor combinacion de indices la siguiente 
# usando la matriz de covarianza
indice <- c(5,28,107,96,48,83,30,26,6,116,38,71,44,111,79,14,70,126,10,12,2,113,21,4,74,73,11,62,99,69,53,65,24,63,78,80,94,108,93,97,3,81,54,92,110,31,42,7,91,119,32,120,35,61,125,51,25,27,45,22,50,85,66,77,109,19,118,87,46,36,105,17,13,15,43,18,56,39,75,88,98,49,59,84,40,58,67)
# para correlacion
# c(7,48,15,2,65,112,113,42,91,68,28,54,76,4,32,11,105,108,92,41,60,12,115,40,47,116,100,103,45,6,73,1,83,26,122,67,46,101,126,89,125,118,59,87,77,120,10,110,3,99,49,114,97,58,27,124,107,5,43,84,39,61,119,93,109,30,117,50,88,25,94,79,31,75,22,51,9,16,57,52,71,85,17,56,8,123,62)
#indice <- aux$indices
ytrain<-y[indice,1:5]
ytest<-y[-indice,1:5]

#Analisis de Correlacion de los datos
cor(ytrain)

comp <-princomp(ytrain,cor=F)
#Seleccionar cuantas o cuales componentes
summary(comp)

x11()
plot(comp,col="red",type="l")
graf1(comp)
x11()
biplot(comp)
abline(h = 0, v = 0, lty = 2, col = 4)

names(comp)
loadings(comp)


cargas<-comp$loadings[,]
score<-function(y,carga)
{
yc<-y-matrix(rep(colMeans(y),nrow(y)),ncol=ncol(y),byrow=TRUE)
salida<-as.matrix(yc)%*%carga
return(salida)
}
comT<-score(ytest,cargas)



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

conglomerado_train<-conglomeradoT[indice]
conglomerado_test<-conglomeradoT[-indice]




########################
#Generación de clase
########################
medias<-c(mean(data[conglomeradoT==1,7]),mean(data[conglomeradoT==2,7]),mean(data[conglomeradoT==3,7]))
medias
names(medias)<-c(1,2,3)
claseC<-as.numeric(names(sort(medias)))
clase<-matrix(NA, ncol=2, nrow=nrow(ytrain))

# ENTRANAMIENTO
clase<-matrix(NA, ncol=2, nrow=nrow(ytrain))
clase
#Grupo Bajo
clase[conglomerado_train==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomerado_train==claseC[1])), byrow=TRUE, ncol=2 )
#Grupo Medio
clase[conglomerado_train==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomerado_train==claseC[2])), byrow=TRUE, ncol=2 )
#Grupo Alto
clase[conglomerado_train==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomerado_train==claseC[3])), byrow=TRUE, ncol=2 )
clase

# Visualizamos la data para el entrenamiento en paralelo la salida desada junto con la clase
matrix(c(y[indice,6],clase[,1],clase[,2]), byrow=FALSE, ncol=3)

# VALIDACION

claseT<-matrix(NA, ncol=2, nrow=nrow(ytest))
claseT[conglomerado_test==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomerado_test==claseC[1])), byrow=TRUE, ncol=2 )
claseT[conglomerado_test==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomerado_test==claseC[2])), byrow=TRUE, ncol=2 )
claseT[conglomerado_test==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomerado_test==claseC[3])), byrow=TRUE, ncol=2 )
claseT

# Visualizamos la data para la validacio en paralelo la salida desada junto con la clase
matrix(c(y[-indice,6],claseT[,1],claseT[,2]), byrow=FALSE, ncol=3)






######################################
# Creamos el objeto red neuronal feedforward
#############################
# PRUEBA CON COMPONENTE 1 Y 2 #
##############################
## Creamos dos conjuntos de datos artificiales: ''P'' es el conjunto
#de datos de entrada y ''target'' el de salida. con el 80% de los datos
######################
target<-clase
target
##
## inicialmente con Comp1 Comp2 con el 88% de la infomarcion de los datos 
########################
P<-matrix(c(comp$score[,1],comp$score[,2]),ncol=2,byrow=TRUE)
P
P_v <-comT[,1:2]

## Creamos el objeto red neuronal feedforward
############################################
net1 <- newff(n.neurons=c(2,2,2), learning.rate.global=0.15, momentum.global=0.9,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
#############################
##Se entrena la red
#######################
result1 <- train(net1,P , target, error.criterium="LMS", report=TRUE, show.step=1.03, n.shows=50 )
######################
# se grafica la red entrenada con los datos de entrenamiento
####
#s <- sim(result1$net, P)
#cbind(round(s),(apply(clase,1,sum)+1))
#round(s)
###################
# Validacion con el 20% restante
##############

s <- sim(result1$net, P_v)
round(s)
dist_uno_uno <- dist(rbind(c(1,1),s))[1:39]
dist_cero_uno <- dist(rbind(c(0,1),s))[1:39]
dist_cero_cero <- dist(rbind(c(0,0),s))[1:39]

salT<-cbind(ytest,round(s), #Se une el vector de salida redondeado
	dist_uno_uno,dist_cero_uno,dist_cero_cero,cbind(((dist_uno_uno)/rowSums(cbind(dist_uno_uno,dist_cero_uno,dist_cero_cero))),((dist_cero_uno)/rowSums(cbind(dist_uno_uno,dist_cero_uno,dist_cero_cero))),((dist_cero_cero)/rowSums(cbind(dist_uno_uno,dist_cero_uno,dist_cero_cero)))	)
)
salT<-data.frame(salT)
colnames(salT)<-c("M_1","M_2","M_3","_M_4","P","X1","X2","D1_1_1","D2_0_1","D3_0_0","P_1_1","P_0_1","P_0_0")
print(salT,digits=5)


s
cbind(round(s), claseT)
tasa<-rep(FALSE,nrow(s))
tasa[round(s)[,1]== claseT[,1] & round(s)[,2]== claseT[,2]]<-TRUE
tasa <- sum(tasa==TRUE)*100/length(tasa)


tasa

ECM_2 <- error.LMS(c(s,claseT,net1))
ECM_2



m <- 0.7
s <- 1.03
for(i in 1:10){
	#print(m)
	#print(s)
	opt(m, s, c(2), P, P_v, clase, claseT)
	#	s <- s + 0.1
}
