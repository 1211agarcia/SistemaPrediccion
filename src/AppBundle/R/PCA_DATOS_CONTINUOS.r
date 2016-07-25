##########################################################
# PCA con variables CONTINUAS
#########################################################

source("PCAfunction.r")
graphics.off()
library(rgl)


#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("datos.txt",header=TRUE,dec=",")
data
#Nombre de columnas a ignorar para este experimento, calclulo de ignora pues es la salida deseada
drops <- c("cant_mats","segunda_opc","Gestion_Plantel","Tipo_Plantel","Nivel_Socioeconomico","Estudio_Padres","primera_opc","opsu")

y <- data[ , !(names(data) %in% drops)]
y


#Se realiza el Analisis de de Componentes Principales usando la matriz de Covarianza #
indice<-sample(1:nrow(y),85)
#indice<-c(77,67,66,37,27,59,75,120,65,90,83,24,114,116,100,29,5,18,19,96,106,121,11,36,44,80,6,4,105,63,73,51,78,86,48,58,32,98,61,23,41,71,49,3,72,56,54,47,79,22,101,115,85,15,107,40,119,46,93,84,69,112,26,30,118,95,13,117,21,111,82,9487,60,1,7,12,45,25,9,91,81,8,62,16,20,88)
ytrain<-y[indice,1:5]
ytest<-y[-indice,]

#Analisis de Correlacion de lso datos

comp_1 <-princomp(ytrain,cor=F)
#Seleccionar cuantas o cuales componentes
summary(comp_1)
x11()
plot(comp_1)
graf1(comp_1)
names(comp_1)
loadings(comp_1)

#########################################
#    Calculo de grupos de salida
conglomerado<-kmeans(y,3)$cluster
conglomerado
conglomerado_train<-conglomerado[indice]
conglomerado_train
conglomerado_test<-conglomerado[-indice]
conglomerado_test
############################################

comp_1_datos<-comp_1$score
summary(comp_1_datos)

