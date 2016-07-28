#Red neurona sin PCA
library(neuralnet)

indice<-sample(1:nrow(y),87)

set.seed(500)
library(MASS)
data <- Boston
apply(data,2,function(x) sum(is.na(x)))
index <- sample(1:nrow(data),round(0.75*nrow(data)))
train <- data[index,]
test <- data[-index,]
lm.fit <- glm(medv~., data=train)
summary(lm.fit)
pr.lm <- predict(lm.fit,test)
MSE.lm <- sum((pr.lm - test$medv)^2)/nrow(test)


######################################
# Creamos el objeto red neuronal feedforward
#############################
# PRUEBA CON variables cuantitativas
##############################
## Creamos dos conjuntos de datos artificiales: ''P'' es el conjunto
#de datos de entrada y ''target'' el de salida. con el 80% de los datos
######################
target<-clase
target
##
## inicialmente con Comp1 Comp2 con el 88% de la infomarcion de los datos 
########################
P2<-data[indice,1:5]
P2

## Creamos el objeto red neuronal feedforward
############################################
net2 <- newff(n.neurons=c(5,3,2,2), learning.rate.global=1e-2, momentum.global=0.5,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
#############################
##Se entrena la red
#######################
result2 <- train(net2,P2 , target, error.criterium="LMS", report=TRUE, show.step=10000, n.shows=39 )
######################
# se grafica la red entrenada con los datos de entrenamiento
####
s <- sim(result1$net2, P2)
cbind(round(s),(apply(clase,1,sum)+1))
round(s)
###################
# Validacion con el 20% restante
##############
P_v <-data[-indice,1:5]
s <- sim(result2$net, P_v)
round(s)
dist_uno_uno <- dist(rbind(c(1,1),s))[1:39]
dist_cero_uno <- dist(rbind(c(0,1),s))[1:39]
dist_cero_cero <- dist(rbind(c(0,0),s))[1:39]

salT<-cbind(ytest,
round(s), #Se une el vector de salida redondeado
	dist_uno_uno,
	dist_cero_uno,
	dist_cero_cero,
	cbind(((dist_uno_uno)/rowSums(cbind(dist_uno_uno,dist_cero_uno,dist_cero_cero))),
		((dist_cero_uno)/rowSums(cbind(dist_uno_uno,dist_cero_uno,dist_cero_cero))),
		((dist_cero_cero)/rowSums(cbind(dist_uno_uno,dist_cero_uno,dist_cero_cero)))
	)
)
salT<-data.frame(salT)
colnames(salT)<-c("M_1","M_2","M_3","_M_4","P","X1","X2","D1_1_1","D2_0_1","D3_0_0","P_1_1","P_0_1","P_0_0")
print(salT,digits=5)


s
cbind(round(s), claseT)
tasa<-rep(FALSE,nrow(s))
tasa[round(s)[,1]== claseT[,1] & round(s)[,2]== claseT[,2]]<-TRUE
tasa <- sum(tasa==TRUE)*100/length(tasa)


tasa

ECM_2 <- error.LMS(c(s,claseT,net1))
ECM_2
