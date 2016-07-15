source("PCA/PCAfunction.r")
graphics.off()
library(rgl)
library(AMORE)
#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("datos.txt",header=TRUE,dec=",")
data
#se verifica el nivel de correlacion entre las variable par ver s es conveniente hacer uso del PCA
drops <- c("segunda_opc","cant_mats","Gestion_Plantel","Tipo_Plantel","Nivel_Socioeconomico","Estudio_Padres","primera_opc","opsu","calculo")
cor(data[ , 1:13])
y <- data[ , 1:13] #esto para trabajar con todas las varibles
#cor(data[ , !(names(data) %in% drops)])
#y <- data[ , !(names(data) %in% drops)]
#Se realiza el Analisis de de Componentes Principales usando la matriz de Covarianza #
indice<-sample(1:nrow(y),48)
#indice<-c(26 , 9 36 30  7 53 13  2 57 11 24 45 34 37 59 43 23 56 32 41 47 18 39 49 17 44  5 33 38 42 12 46 16 58 19 40  1 14 15 54 35  6 55 20  3  4 22 31)
ytrain<-y[indice,]
ytest<-y[-indice,]
conglomeradoT<-kmeans(y,3)$cluster
conglomerado<-conglomeradoT[indice]
conglomeradoP<-conglomeradoT[-indice]
com1<-princomp(ytrain,cor=F)$score
summary(com1)
cargas<-princomp(ytrain,cor=F)$loadings[,]
#com1<-com$score[indice,]
score<-function(y,carga)
{
yc<-y-matrix(rep(colMeans(y),nrow(y)),ncol=ncol(y),byrow=TRUE)
salida<-as.matrix(yc)%*%carga
return(salida)
}
comT<-score(ytest,cargas)
#Seleccionar cuantas o cuales componentes
#Intepretar las componentes

biplot(com)#no se que significa
abline(h = 0, v = 0, lty = 2, col = 4)

#Grafica de las componentes
x11()
par(mfrow=c(1,3))
plot(com1[,1],com1[,2],pch=21,bg=c("red", "blue","green")[unclass(conglomerado)])
plot(com1[,1],com1[,3],pch=21,bg=c("red", "blue","green")[unclass(conglomerado)])
plot(com1[,2],com1[,3],pch=21,bg=c("red", "blue","green")[unclass(conglomerado)])

################################
# Graficacion de 3 componentes #
################################
plot3d(com1[,1:3], col=c("red", "blue","green")[unclass(conglomerado)])
####################
# Redes neuronales #
####################
#Generación de clase
medias<-c(mean(data[conglomerado==1,14]),mean(data[conglomerado==2,14]),mean(data[conglomerado==3,14]))
names(medias)<-c(1,2,3)
claseC<-as.numeric(names(sort(medias)))
clase<-matrix(NA, ncol=2, nrow=nrow(ytrain))

#creacion del primer grupo
clase[conglomerado==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomerado==claseC[1])), byrow=TRUE, ncol=2 )
#Grupo Plata
clase[conglomerado==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomerado==claseC[2])), byrow=TRUE, ncol=2 )
#Grupo Oro
clase[conglomerado==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomerado==claseC[3])), byrow=TRUE, ncol=2 )

claseT<-matrix(NA, ncol=2, nrow=nrow(ytest))
claseT[conglomeradoP==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomeradoP==claseC[1])), byrow=TRUE, ncol=2 )
claseT[conglomeradoP==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomeradoP==claseC[2])), byrow=TRUE, ncol=2 )
claseT[conglomeradoP==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomeradoP==claseC[3])), byrow=TRUE, ncol=2 )



######################################
# Creamos el objeto red neuronal feedforward
#############################
# PRUEBA CON COMPONENTE 1 Y 2 #
##############################
## Creamos dos conjuntos de datos artificiales: ''P'' es el conjunto
#de datos de entrada y ''target'' el de salida. con el 80% de los datos
######################
target1<-clase
target1
##
## inicialmente con Comp1 Comp2 comp3 con el 88% de los datos 
########################
P1<-matrix(c(com1[,1],com1[,2],com1[,3]),ncol=3,byrow=TRUE)
P1

## Creamos el objeto red neuronal feedforward
############################################
net1 <- newff(n.neurons=c(3,10,2), learning.rate.global=1e-2, momentum.global=0.5,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
#############################
##Se entrena la red
#######################
result1 <- train(net1,P1 , target1, error.criterium="LMS", report=TRUE, show.step=10000, n.shows=5 )
######################
# se grafica la red entrenada con lso datos de entrenamiento
####
s <- sim(result1$net, P1)
cbind(round(s),(apply(clase,1,sum)+1))
round(s)
###################
# Validacion con el 20% restante
##############
P_v <-comT[,1:3]
s <- sim(result1$net, P_v)
round(s)
salT<-cbind(round(s),dist(rbind(c(1,1),s))[1:12],dist(rbind(c(0,1),s))[1:12],dist(rbind(c(0,0),s))[1:12],

cbind((dist(rbind(c(1,1),s))[1:12])/rowSums(cbind(dist(rbind(c(1,1),s))[1:12],dist(rbind(c(0,1),s))[1:12],dist(rbind(c(0,0),s))[1:12]))
,(dist(rbind(c(0,1),s))[1:12])/rowSums(cbind(dist(rbind(c(1,1),s))[1:12],dist(rbind(c(0,1),s))[1:12],dist(rbind(c(0,0),s))[1:12]))
,(dist(rbind(c(0,0),s))[1:12])/rowSums(cbind(dist(rbind(c(1,1),s))[1:12],dist(rbind(c(0,1),s))[1:12],dist(rbind(c(0,0),s))[1:12]))))
salT<-data.frame(salT)

colnames(salT)<-c("X1","X2","D1","D2","D3","P1","P2","P3")
print(salT,digits=2)