opt<-function(m,s,capas, P, P_v, clase, claseT){

net1 <- newff(n.neurons=c(2,capas,2), learning.rate.global=0.1, momentum.global=m,
error.criterium="LMS", Stao=NA, hidden.layer="sigmoid",
output.layer="sigmoid", method="ADAPTgdwm")
result1 <- train(net1,P , target, error.criterium="LMS", report=TRUE, show.step=s, n.shows=5 )
s <- sim(result1$net, P)
print("Entrenando")
tasa<-rep(FALSE,nrow(s))
tasa[round(s)[,1]== clase[,1] & round(s)[,2]== clase[,2]]<-TRUE
tasa <- sum(tasa==TRUE)*100/length(tasa)

print(tasa)
ECM_2 <- error.LMS(c(s,clase,net1))
print(ECM_2) 

print("Validando")
s <- sim(result1$net, P_v)

tasa<-rep(FALSE,nrow(s))
tasa[round(s)[,1]== claseT[,1] & round(s)[,2]== claseT[,2]]<-TRUE
tasa <- sum(tasa==TRUE)*100/length(tasa)

print(tasa)

ECM_2 <- error.LMS(c(s,claseT,net1))
print(ECM_2) 

}
