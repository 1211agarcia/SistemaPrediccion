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