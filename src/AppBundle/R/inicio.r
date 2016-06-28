#se cargan los datos colocando como parametros que los decimales seran separados por un ","
y<-read.table("datos.txt",header=TRUE,dec=",")
y
#Se realiza el Analisis de de Componentes Principales usando la matriz de Covarianza #
com1<-princomp(y,cor=F)
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

plot(com1$score[,1],com1$score[,2],pch=21,
bg=c("blue","red","green")[unclass(clase)])


plot(com1$score[,1],com1$score[,3])
sal<-c(1,3,3,3,3,4,4,4,4,4,4,5,5,5,5,6,6,6,7,7,7,8,10,10,10,11,11,12,12,12,13,13,15,15,15,15,15,15,15,16,16,16,16,16,16,16,17,17,17,17,17,17,17,18,18,18,18,18,19,19)
clase<-rep(FALSE,length(sal))
clase[sal<12]<-1 #Grupo Bronce
clase[sal>=12&sal<16]<-2 #Grupo Plata
clase[sal>=16]<-3 #Grupo Oro

plot(com1$score[,1],com1$score[,3],pch=21,
bg=c("blue","red","green")[unclass(clase)])

################################
# Graficacion de 3 componentes #
################################
# no funciono
require(grDevices) # for colours
x <- -6:16
op <- par(mfrow = c(2, 2))
contour(outer(com1$score[,1],com1$score[,2]), method = "edge", vfont = c("sans serif", "plain"))
z <- outer(x, sqrt(abs(x)), FUN = "/") image(x, x, z)
contour(x, x, z, col = "pink", add = TRUE, method = "edge",       vfont = c("sans serif", "plain"))
contour(x, x, z, ylim = c(1, 6), method = "simple", labcex = 1,        xlab = com1$score[,1], ylab = com1$score[,2])
contour(x, x, z, ylim = c(-6, 6), nlev = 20, lty = 2, method = "simple",        main = "20 levels; \"simple\" labelling method")
par(op)


#Redes neuronales
library(AMORE)
#linealmente no separable
target1<-matrix(c(0,1,1,0),ncol=1,byrow=TRUE)
P1<-matrix(c(0,0,0,1,1,0,1,1),ncol=2,byrow=TRUE)
net1 <- newff(n.neurons=c(2,3,1), learning.rate.global=1e-2, momentum.global=0.5,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
result1 <- train(net1,P1 , target1, error.criterium="LMS", report=TRUE, show.step=10000, n.shows=5 )
y <- sim(result1$net, P1)

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