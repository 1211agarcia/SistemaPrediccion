indice <- PCAoptimo(y,1,87,F)$indices
ytrain<-y[indice,1:5]
ytest<-y[-indice,1:5]
comp <-princomp(ytrain,cor=F)
cargas<-comp$loadings[,]

comT<-score(ytest,cargas)

conglomerado_train<-conglomeradoT[indice]
conglomerado_test<-conglomeradoT[-indice]

clase<-matrix(NA, ncol=2, nrow=nrow(ytrain))
#Grupo Bajo
clase[conglomerado_train==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomerado_train==claseC[1])), byrow=TRUE, ncol=2 )
#Grupo Medio
clase[conglomerado_train==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomerado_train==claseC[2])), byrow=TRUE, ncol=2 )
#Grupo Alto
clase[conglomerado_train==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomerado_train==claseC[3])), byrow=TRUE, ncol=2 )
clase
claseT<-matrix(NA, ncol=2, nrow=nrow(ytest))
claseT[conglomerado_test==claseC[1],]<-matrix(rep(t(c(0,0)), sum(conglomerado_test==claseC[1])), byrow=TRUE, ncol=2 )
claseT[conglomerado_test==claseC[2],]<-matrix(rep(t(c(0,1)), sum(conglomerado_test==claseC[2])), byrow=TRUE, ncol=2 )
claseT[conglomerado_test==claseC[3],]<-matrix(rep(t(c(1,1)), sum(conglomerado_test==claseC[3])), byrow=TRUE, ncol=2 )
claseT

target<-clase
P<-matrix(c(comp$score[,1],comp$score[,2]),ncol=2,byrow=TRUE)

P_v <-comT[,1:2]

net1 <- newff(n.neurons=c(2,2,2), learning.rate.global=0.15, momentum.global=0.9,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")


result1 <- train(net1,P , target, error.criterium="LMS", report=TRUE, show.step=1.03, n.shows=50 )

print("Train")
s <- sim(result1$net, P)
tasa<-rep(FALSE,nrow(s))
tasa[round(s)[,1]== clase[,1] & round(s)[,2]== clase[,2]]<-TRUE
tasa <- sum(tasa==TRUE)*100/length(tasa)
tasa
ECM_2 <- error.LMS(c(s,clase,net1))
ECM_2


print("Test")
s <- sim(result1$net, P_v)
tasa<-rep(FALSE,nrow(s))
tasa[round(s)[,1]== claseT[,1] & round(s)[,2]== claseT[,2]]<-TRUE
tasa <- sum(tasa==TRUE)*100/length(tasa)
tasa
ECM_2 <- error.LMS(c(s,claseT,net1))
ECM_2


