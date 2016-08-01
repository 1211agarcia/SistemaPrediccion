myTrain<-function(m,s,capas, P, P_v, clase, claseT, p_ecm){

net1 <- newff(n.neurons=c(2,capas,2), learning.rate.global=p_ecm, momentum.global=m,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
result1 <- train(net1,P , target, error.criterium="LMS", report=TRUE, show.step=s, n.shows=5 )
s <- sim(result1$net, P)
print("Entrenando")
tasa_1<-rep(FALSE,nrow(s))
tasa_1[round(s)[,1]== clase[,1] & round(s)[,2]== clase[,2]]<-TRUE
tasa_1 <- sum(tasa_1==TRUE)*100/length(tasa_1)

print(tasa_1)
ECM_1 <- error.LMS(c(s,clase,net1))
print(ECM_1) 

print("Validando")
s <- sim(result1$net, P_v)

tasa_2<-rep(FALSE,nrow(s))
tasa_2[round(s)[,1]== claseT[,1] & round(s)[,2]== claseT[,2]]<-TRUE
tasa_2 <- sum(tasa_2==TRUE)*100/length(tasa_2)

print(tasa_2)

ECM_2 <- error.LMS(c(s,claseT,net1))
print(ECM_2) 

return(list(ecm_1=ECM_1, t_1=tasa_1, ecm_2=ECM_2, t_2=tasa_2))
}
