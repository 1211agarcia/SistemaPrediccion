##########################################################
# PCA con variables CONTINUAS
#########################################################

#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("muestra_real.txt",header=TRUE)
data
#Nombre de columnas a ignorar para este experimento, calclulo de ignora pues es la salida deseada
drops <- c("cant_mat","escuela","gestion_plantel","tipo_plantel","nivelsocioeconomico","estudio_padres","genero","es_opsu")

y <- data[ , !(names(data) %in% drops)]
y
cor(y[ , 1:5])
cor(y)

#Se realiza el Analisis de de Componentes Principales usando la matriz de Covarianza #
indice<-sample(1:nrow(y),85)
# 17  14  96  98  41 119  81   7  82  24  47  15 115  19  12 124  50 112  88  59   2  23  58  77
#[25] 114  71 108  34  29  69  37   5  42  25  26  75 113  89 111 106   9  85   8  18  46  13  86  20
#[49]  66  49 116  95 118 101  33  57  21 109 120  99  31  61  40  43  94  84  62  44   3  48  63  74
#[73]  16  39 105  54 110  10  97  78 104 100  87   6  67

indice
ytrain<-y[indice,1:5]
ytest<-y[-indice,]

#Analisis de Correlacion de los datos
cor(ytrain)

comp_1 <-princomp(ytrain,cor=F)
#Seleccionar cuantas o cuales componentes
summary(comp_1)

x11()
plot(comp_1)
graf1(comp_1)
x11()
biplot(com1)
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

