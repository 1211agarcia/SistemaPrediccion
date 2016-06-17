y<-read.table("datos.txt",header=TRUE,dec=",")
com1<-princomp(y,cor=F)
summary(com1)
plot(com1)
names(com1)
loadings(com1)
par(mfrow=c(2,2))
plot(com1$score[,1],com1$score[,2])
sal<-c(1,3,3,3,3,4,4,4,4,4,4,5,5,5,5,6,6,6,7,7,7,8,10,10,10,11,11,12,12,12,13,13,15,15,15,15,15,15,15,16,16,16,16,16,16,16,17,17,17,17,17,17,17,18,18,18,18,18,19,19)
clase<-rep(FALSE,length(sal))
clase[sal<12]<-1
clase[sal>=12&sal<16]<-2
clase[sal>=16]<-3

plot(com1$score[,1],com1$score[,2],pch=21,
bg=c("blue","red","green")[unclass(clase)])



com2<-princomp(y,cor=T)
summary(com2)
plot(com2)
names(com2)
loadings(com2)
