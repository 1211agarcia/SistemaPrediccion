# Redes neuronales artificiales
# Si se usa nnet para regresi�n en lugar de clasificaci�n se debe usar
# el par�metro linout=T
 
 
data(iris)
iris <- read.table("datos.txt",header=TRUE,dec=",")
iris

class(iris[,])

sal<-iris[,14]
clase<-rep(FALSE,length(sal))
clase[sal<12]<-1 #Grupo Bronce
clase[sal>=12&sal<16]<-2 #Grupo Plata
clase[sal>=16]<-3 #Grupo Oro
clase

iris <- cbind(iris, clase)

# Selecci�n de una submuestra de 105 (el 70% de los datos)
set.seed(101)
iris.indices <- sample(1:nrow(iris),size=48)
iris.indices
iris.entrenamiento <- iris[iris.indices,]
iris.entrenamiento
iris.test <- iris[-iris.indices,]
 
# Previamente se usar� train para ver el valor de los par�metros size y decay
# size: n�mero de unidades ocultas intermedias
# decay: se usa para evitar el sobre ajuste
 
library(caret)
parametros <- train(calculo~., data=iris.entrenamiento, method="nnet", trace=F)
size <- parametros$bestTune$size
decay <- parametros$bestTune$decay
parametros$bestTune
 
library(nnet)
# Entrenamiento de la red neuronal con los valores de train
modelo <- nnet(calculo ~ ., size=size, decay=decay, trace=F,
               data=iris.entrenamiento)
modelo
 
# Predicci�n. Se crea un data frame con las probabilidades y los nombres de las
# especies


predicciones <- data.frame(predict(modelo, iris.test),
                           clas=predict(modelo,iris.test))
predicciones
 
# Matriz de confusi�n
names(iris.test)
mc <- table(predicciones$clas,iris.test$calculo, dnn = c("Asignado","Real"))
mc
# Aciertos en %
aciertos <- sum(diag(mc)) / nrow(iris.test) * 100
aciertos