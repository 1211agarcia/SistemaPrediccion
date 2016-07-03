source("PCA/PCAfunction.r")
#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("datos.txt",header=TRUE,dec=",")
data
#se verifica el nivel de correlacion entre las variable par ver s es conveniente hacer uso del PCA
drops <- c("segunda_opc","cant_mats","Gestion_Plantel","Tipo_Plantel","Nivel_Socioeconomico","Estudio_Padres","primera_opc","opsu","calculo")
cor(data[ , 1:13])
y <- data[ , 1:13] #esto para trabajar con todas las varibles
cor(data[ , !(names(data) %in% drops)])
y <- data[ , !(names(data) %in% drops)]
#Se realiza el Analisis de de Componentes Principales usando la matriz de Covarianza #
com1<-princomp(y,cor=F)
com1
#Seleccionar cuantas o cuales componentes
summary(com1)
x11()
plot(com1)
graf1(com1)
names(com1)
#Intepretar las componentes
loadings(com1)
x11()
graf(com1,1,2)
x11()
graf(com1,3,4)
x11()
graf(com1,5,6)
x11()
graf(com1,7,8)
x11()
biplot(com1)#no se que significa
abline(h = 0, v = 0, lty = 2, col = 4)

#Grafica de las componentes
x11()
par(mfrow=c(2,2))
sal<-data[,14]
clase<-rep(FALSE,length(sal))
clase[sal<12]<-1 #Grupo Bronce
clase[sal>=12&sal<16]<-2 #Grupo Plata
clase[sal>=16]<-3 #Grupo Oro

plot(com1$score[,1],com1$score[,2],pch=21,bg=c("red", "blue","green")[unclass(clase)])
plot(com1$score[,1],com1$score[,3],pch=21,bg=c("red", "blue","green")[unclass(clase)])
plot(com1$score[,1],com1$score[,4],pch=21,bg=c("red", "blue","green")[unclass(clase)])
plot(com1$score[,1],com1$score[,5],pch=21,bg=c("red", "blue","green")[unclass(clase)])


################################
# Graficacion de 3 componentes #
################################
library(rgl)
plot3d(com1$scores[,1:3], col=c("red", "blue","green")[unclass(clase)])

####################
# Redes neuronales #
####################
library(AMORE)

######################################
# Creamos el objeto red neuronal feedforward
#############################
# PRUEBA CON COMPONENTE 1 Y 2 #
##############################
## Creamos dos conjuntos de datos artificiales: ''P'' es el conjunto
#de datos de entrada y ''target'' el de salida. con el 80% de los datos
######################
target1<-matrix(c(clase[1:48]),ncol=1,byrow=TRUE)
target1
##
## inicialmente con Comp1 Comp2 con el 80% de los datos
########################
P1<-matrix(c(com1$score[1:48,1],com1$score[1:48,2]),ncol=2,byrow=TRUE)
P1

## Creamos el objeto red neuronal feedforward
############################################
net1 <- newff(n.neurons=c(2,3,1), learning.rate.global=1e-2, momentum.global=0.5,
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
s
plot3d(P1,s, col=c("red", "blue","green")[unclass(clase[1:48])])

x11()
par(mfrow=c(2,2))
plot(P1[,1],s,pch=21,bg=c("red", "blue","green")[unclass(clase[1:48])])
plot(P1[,2],s,pch=21,bg=c("red", "blue","green")[unclass(clase[1:48])])



###################
# Validacion con el 20% restante
##############
P_v <-matrix(c(com1$score[49:60,1],com1$score[49:60,2]),ncol=2,byrow=TRUE)
target_v<-matrix(c(clase[49:60]),ncol=1,byrow=TRUE)

s <- sim(result1$net, P_v)
s
# se grafica
plot3d(P_v,s, col=c("red", "blue","green")[unclass(clase[49:60])])

#se grafica la validacion
plot(P_v[,1],s,pch=21,bg=c("red", "blue","green")[unclass(clase[49:60])])
plot(P_v[,2],s,pch=21,bg=c("red", "blue","green")[unclass(clase[49:60])])


######################################3
P_v <-matrix(c(com1$score[60,1],com1$score[60,2]),ncol=2,byrow=TRUE)
target_v<-matrix(c(clase[49:60]),ncol=1,byrow=TRUE)

s <- sim(result1$net, P_v)
names(
result1$net
$output
)

