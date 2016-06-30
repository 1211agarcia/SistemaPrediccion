#Analisis de componentes
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