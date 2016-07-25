# Modelo de Red neuronal con Variables continuas
library(AMORE)
source("PCAfunction.r")

#Lectura de Datos
data <- read.table("muestra_real_2.txt",header=TRUE)
data
#Se remueven las variables categoricas
drops <- c("cant_mat","opsu","gestion_plantel","tipo_plantel","nivel_socioeco","nivel_estudios_padres","genero","escuela")
y <- data[ , !(names(data) %in% drops)]
y

indice<-sample(1:nrow(y),85)
#indice<-c(77,67,66,37,27,59,75,120,65,90,83,24,114,116,100,29,5,18,19,96,106,121,11,36,44,80,6,4,105,63,73,51,78,86,48,58,32,98,61,23,41,71,49,3,72,56,54,47,79,22,101,115,85,15,107,40,119,46,93,84,69,112,26,30,118,95,13,117,21,111,82,9487,60,1,7,12,45,25,9,91,81,8,62,16,20,88)
ytrain<-y[indice,1:5]
ytest<-y[-indice,]

#Calculo de Grupos para las salidas
conglomeradoT<-kmeans(y,3)$cluster
conglomerado<-conglomeradoT[indice]
conglomeradoP<-conglomeradoT[-indice]
medias<-c(mean(y[conglomerado==1,6]),mean(y[conglomerado==2,6]),mean(y[conglomerado==3,6]))
names(medias)<-c(1,2,3)
medias
claseC<-as.numeric(names(sort(medias)))
clase<-matrix(NA, ncol=2, nrow=nrow(ytrain))

#creacion del primer grupo bajo
clase[conglomerado==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomerado==claseC[1])), byrow=TRUE, ncol=2 )
#Grupo medio
clase[conglomerado==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomerado==claseC[2])), byrow=TRUE, ncol=2 )
#Grupo alto
clase[conglomerado==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomerado==claseC[3])), byrow=TRUE, ncol=2 )

claseT<-matrix(NA, ncol=2, nrow=nrow(ytest))
claseT[conglomeradoP==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomeradoP==claseC[1])), byrow=TRUE, ncol=2 )
claseT[conglomeradoP==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomeradoP==claseC[2])), byrow=TRUE, ncol=2 )
claseT[conglomeradoP==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomeradoP==claseC[3])), byrow=TRUE, ncol=2 )


######################################
# Creamos el objeto red neuronal feedforward
############################################################
# PRUEBA CON ENTRADAS MAT_1, MAT_2, MAT_3, MAT_4, PROMEDIO #
############################################################
## Creamos dos conjuntos de datos artificiales: ''P'' es el conjunto
#de datos de entrada y ''target'' el de salida. con el 80% de los datos
######################
target-clase
target
##
## inicialmente con Comp1 Comp2 comp3 con el 88% de los datos 
########################
P<-matrix(c(ytrain[,1],ytrain[,2],ytrain[,3],ytrain[,4],ytrain[,5]),ncol=5,byrow=TRUE)
P

## Creamos el objeto red neuronal feedforward
############################################
net1 <- newff(n.neurons=c(5,10,2), learning.rate.global=1e-2, momentum.global=0.5,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
#############################
##Se entrena la red
#######################
result1 <- train(net1,P , target, error.criterium="LMS", report=TRUE, show.step=10000, n.shows=5 )
######################
# se grafica la red entrenada con lso datos de entrenamiento
####
s <- sim(result1$net, P)
cbind(round(s),(apply(clase,1,sum)+1))
round(s)
###################
# Validacion con el 20% restante
##############
s <- sim(result1$net, ytest)
round(s)
salT<-cbind(round(s),dist(rbind(c(1,1),s))[1:12],dist(rbind(c(0,1),s))[1:12],dist(rbind(c(0,0),s))[1:12],

cbind((dist(rbind(c(1,1),s))[1:12])/rowSums(cbind(dist(rbind(c(1,1),s))[1:12],dist(rbind(c(0,1),s))[1:12],dist(rbind(c(0,0),s))[1:12]))
,(dist(rbind(c(0,1),s))[1:12])/rowSums(cbind(dist(rbind(c(1,1),s))[1:12],dist(rbind(c(0,1),s))[1:12],dist(rbind(c(0,0),s))[1:12]))
,(dist(rbind(c(0,0),s))[1:12])/rowSums(cbind(dist(rbind(c(1,1),s))[1:12],dist(rbind(c(0,1),s))[1:12],dist(rbind(c(0,0),s))[1:12]))))
