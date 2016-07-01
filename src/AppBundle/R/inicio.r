#se cargan los datos colocando como parametros que los decimales seran separados por un ","
y<-read.table("datos.txt",header=TRUE,dec=",")
y
#Se realiza el Analisis de de Componentes Principales usando la matriz de Covarianza #
com1<-princomp(y[,1:4],cor=F)
#Seleccionar cuantas o cuales componentes
summary(com1)
plot(com1)
names(com1)
#Intepretar las componentes
loadings(com1)
#x11()
#graf(com1,2)
x11()
biplot(com1)#no se que significa

#Grafica de las componentes
x11()
par(mfrow=c(2,2))
plot(com1$score[,1],com1$score[,2])
sal<-c(1,3,3,3,3,4,4,4,4,4,4,5,5,5,5,6,6,6,7,7,7,8,10,10,10,11,11,12,12,12,13,13,15,15,15,15,15,15,15,16,16,16,16,16,16,16,17,17,17,17,17,17,17,18,18,18,18,18,19,19)
clase<-rep(FALSE,length(sal))
clase[sal<12]<-1 #Grupo Bronce
clase[sal>=12&sal<16]<-2 #Grupo Plata
clase[sal>=16]<-3 #Grupo Oro

plot(com1$score[,1],com1$score[,2],pch=21,bg=c("red", "blue","green")[unclass(clase)])


plot(com1$score[,1],com1$score[,3])
sal<-c(1,3,3,3,3,4,4,4,4,4,4,5,5,5,5,6,6,6,7,7,7,8,10,10,10,11,11,12,12,12,13,13,15,15,15,15,15,15,15,16,16,16,16,16,16,16,17,17,17,17,17,17,17,18,18,18,18,18,19,19)
clase<-rep(FALSE,length(sal))
clase[sal<12]<-1 #Grupo Bronce
clase[sal>=12&sal<16]<-2 #Grupo Plata
clase[sal>=16]<-3 #Grupo Oro

plot(com1$score[,1],com1$score[,3],pch=21,
bg=c("red", "blue","green")[unclass(clase)])

################################
# Graficacion de 3 componentes #
################################
library(rgl)
plot3d(com1$scores[,1:3], col=c("red", "blue","green")[unclass(clase)])


#grafico biplot 3d
text3d(com1$scores[,1:3],texts=rownames(y))
text3d(com1$loadings[,1:3], texts=rownames(com1$loadings), col="red")
coords <- NULL
for (i in 1:nrow(com1$loadings)) {
  coords <- rbind(coords, rbind(c(0,0,0),com1$loadings[i,1:3]))
}
lines3d(coords, col="red", lwd=4)


#Redes neuronales
library(AMORE)
#linealmente no separable
## Creamos dos conjuntos de datos artificiales: ''P'' es el conjunto
#de datos de entrada y ''target'' el de salida.
target1<-matrix(c(clase),ncol=1,byrow=TRUE)
P1<-matrix(c(com1$score[,1],com1$score[,2]),ncol=2,byrow=TRUE)
## Creamos el objeto red neuronal feedforward
net1 <- newff(n.neurons=c(2,3,1), learning.rate.global=1e-2, momentum.global=0.5,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
##Se entrena la red
result1 <- train(net1,P1 , target1, error.criterium="LMS", report=TRUE, show.step=10000, n.shows=5 )
#simulacion
Ps<-matrix(c(com1$score[1,1],com1$score[1,2]),ncol=2,byrow=TRUE)
s <- sim(result1$net, Ps)


plot3d(P1,s, col=c("red", "blue","green")[unclass(clase)])

#lecetura de datos para entrenar
ent<-read.table("entre.txt",header=FALSE,dec=",")
#salida deseada
sal_e<-c(1,3,3,3,3,4,4,4,4,4,4,5,5,5,5,6,6,6,7,7,7,8,10,10,10,11,11,12,12,12,13,13,15,15,15,15,15,15,15,16,16,16,16,16,16,16,17,17)
clase_e<-rep(FALSE,length(sal_e))
clase_e[sal_e<12]<-1 #Grupo Bronce
clase_e[sal_e>=12&sal_e<16]<-2 #Grupo Plata
clase_e[sal_e>=16]<-3 #Grupo Oro
sal_v<-c(17,17,17,17,17,18,18,18,18,18,19,19)
clase_v<-rep(FALSE,length(sal_v))
clase_v[sal_v<12]<-1 #Grupo Bronce
clase_v[sal_v>=12&sal_v<16]<-2 #Grupo Plata
clase_v[sal_v>=16]<-3 #Grupo Oro
#objeto para salida deseada
target_e<-matrix(clase_e,ncol=1,byrow=TRUE)

#PRUEBA CON COMPONENTE 1 Y 2
#datos para entrenar
P_e<-matrix(c(com1$score[1:48,1],com1$score[1:48,2]),ncol=2,byrow=TRUE)

## Creamos el objeto red neuronal feedforward
net1 <- newff(n.neurons=c(2,3,1), learning.rate.global=1e-2, momentum.global=0.5,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
##Se entrena la red
result_e <- train(net1,P_e , target_e, error.criterium="LMS", report=TRUE, show.step=10000, n.shows=5 )

#simulacion
P_v<-matrix(c(com1$score[49:60,1],com1$score[49:60,2]),ncol=2,byrow=TRUE)
s <- sim(result_e$net, P_v)


plot3d(P_v,s, col=c("red", "blue","green")[unclass(clase_v)])
x11()
s <- sim(result_e$net, P_e)
plot3d(P_e,s, col=c("red", "blue","green")[unclass(clase_e)])


#PRUEBA CON COMPONENTE 1 , 2 Y 3 ###############################################
#datos para entrenar
P_e<-matrix(c(com1$score[1:48,1],com1$score[1:48,2],com1$score[1:48,3]),ncol=3,byrow=TRUE)

## Creamos el objeto red neuronal feedforward
net1 <- newff(n.neurons=c(3,3,1), learning.rate.global=1e-2, momentum.global=0.5,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
##Se entrena la red
result_e <- train(net1,P_e , target_e, error.criterium="LMS", report=TRUE, show.step=10000, n.shows=5 )

#simulacion
P_v<-matrix(c(com1$score[49:60,1],com1$score[49:60,2],com1$score[49:60,3]),ncol=3,byrow=TRUE)
s <- sim(result_e$net, P_v)

#PRUEBA CON COMPONENTE 1 , 2 Y 3 4 ###############################################
#datos para entrenar
P_e<-matrix(c(com1$score[1:48,1],com1$score[1:48,2],com1$score[1:48,3],com1$score[1:48,4]),ncol=4,byrow=TRUE)

## Creamos el objeto red neuronal feedforward
net1 <- newff(n.neurons=c(4,5,1), learning.rate.global=1e-2, momentum.global=0.5,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
##Se entrena la red
result_e <- train(net1,P_e , target_e, error.criterium="LMS", report=TRUE, show.step=10000, n.shows=5 )

#simulacion
P_v<-matrix(c(com1$score[49:60,1],com1$score[49:60,2],com1$score[49:60,3],com1$score[49:60,4]),ncol=4,byrow=TRUE)
s <- sim(result_e$net, P_v)



require(AMORE)
## Creamos dos conjuntos de datos artificiales: ''P'' es el conjunto de datos de entrada y ''target'' el de salida.
P <- matrix(sample(seq(-1,1,length=500), 500, replace=FALSE), ncol=1)
target <- P^2 + rnorm(500, 0, 0.5)
## Creamos el objeto red neuronal feedforward
net.start <- newff(n.neurons=c(1,3,1), learning.rate.global=1e-2, momentum.global=0.5,error.criterium="LMS",Stao=NA,hidden.layer="
sigmoid",output.layer="sigmoid",method="ADAPTgdwm")
## Entrenamos la red según P y target
result <- train(net.start, P, target, error.criterium="LMS",
report=TRUE, show.step=100, n.shows=5 )
str(result)
#objeto red neuronal entrenada con pesos y tendencias ajustadas mediante el entrenamiento adaptativo backpropagation con el método de momentum (detallado en el apartado anterior)
#matriz con los errores obtenidos durante el entrenamiento
result$Merror
#[,1]
#[1,] 0.2753484
#[2,] 0.2749079
#[3,] 0.2746274
#[4,] 0.2744657
#[5,] 0.2743568
## Gráficos para remarcar que ahora la red entrenada en un elemento de la lista resultante
y <- sim(result$net, P)
#vector de 500 elementos
str(y)
#num [1:500, 1] 0.0374 0.8303 0.7052 0.0704 0.2761 ...
plot(P,y, col="blue", pch="+")
points(P,target, col="red", pch="x")