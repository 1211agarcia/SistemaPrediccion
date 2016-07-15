# Calculo de Promedio de Grupos para salida de RNA
# retorna una vector con los promedio de los grupos de 100 iteraciones
prom_clases<-function(y,target)
{
yc<-y-matrix(rep(colMeans(y),nrow(y)),ncol=ncol(y),byrow=TRUE)
salida<-as.matrix(yc)%*%carga
return(salida)
}