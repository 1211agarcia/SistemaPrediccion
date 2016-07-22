##########################################################
# PCA con variables CONTINUAS
#########################################################

#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("nuevos_datos.txt",header=TRUE)
data
#Nombre de columnas a ignorar para este experimento, calclulo de ignora pues es la salida deseada
drops <- c("cant_mat","escuela","gestion_plantel","tipo_plantel","nivelsocioeconomico","estudio_padres","genero","es_opsu")

y <- data[ , !(names(data) %in% drops)]
y
cor(y[ , 1:5])
cor(y)

#Se realiza el Analisis de de Componentes Principales usando la matriz de Covarianza #
indice<-sample(1:nrow(y),84)
#indice<-c(26 , 9 36 30  7 53 13  2 57 11 24 45 34 37 59 43 23 56 32 41 47 18 39 49 17 44  5 33 38 42 12 46 16 58 19 40  1 14 15 54 35  6 55 20  3  4 22 31)
ytrain<-y[indice,1:5]
ytest<-y[-indice,]

#Analisis de Correlacion de lso datos
cor(ytrain)

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

