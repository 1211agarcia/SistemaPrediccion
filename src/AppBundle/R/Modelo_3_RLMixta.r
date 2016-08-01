#Regresion Mixta
#para generar las varibles dummy
library(dummy)
#regresion mixta
library(nlme)

#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("muestra_estudiantes.txt",header=TRUE)
data
#Nombre de columnas a ignorar para este experimento, calclulo de ignora pues es la salida deseada
drops <- c("cant_mat")
#se descarta Cant_cats por tener correlacion poco significativa
data <- data[ , !(names(data) %in% drops)]
data


categories(x=data,p="all")

#Contruimos las variables dummy o dicotomicas de las varibles categoricas
A <- dummy(x=data)


y <- data[,6]
y
x <- as.matrix(cbind(data[,1:5], (dummies_train)))
x <- asdata[,1:5]
x
c(A[,1])
[,2]
mode(c(A[,1]))
mode(c(A[,1]))
p <- c(A[,1])
p2 <- c(A[,2])
? lme
fm2 <- lme(y ~ p + p2, data = Orthodont, random = ~ 1)
summary(fm2)
distance
age


fm2 <- lme(lmList(y ~ x[,1]+x[,2]+x[,3]+x[,4]| Subject))
 ncol(A)



pairs(data)
cor(data)




x <- data[,1:5]
x

x11()
par(mfrow=c(1,2))
plot(y,x[,1])
plot(y,x[,2])
x11()
par(mfrow=c(1,2))
plot(y,x[,3])
plot(y,x[,4])
x11()
par(mfrow=c(1,1))
plot(y,x[,5])
#
mod1 <- lm(y ~ x[,1] + x[,2] + x[,3] + x[,4] + x[,5])
#Analsis de Modelo
summary(mod1)

# Other useful functions 
coefficients(mod1) # model coefficients
confint(mod1, level=0.95) # CIs for model parameters 
fitted(mod1) # predicted values
residuals(mod1) # residuals
anova(mod1) # anova table 
vcov(mod1) # covariance matrix for model parameters 
influence(mod1) # regression diagnostics

resi = residuals(mod1)

#para la prueba de No normalidad
shapiro.test(residuals(mod1))

#para la prueba de Homogenidad de los datos
#crear un factor 
library(Rcmdr)
fac=NULL
for(i in 1:6){
fac=c(fac,rep(i,21))}
fac
levene.test(resi, fac)

#Prueba de Aletoridad de los datos
secu=c(seq(1,126))

x11()
plot(secu,resi,col="red",type="l")
abline(h = 0, v = 0, lty = 2, col = 4)
# diagnostic plots 
layout(matrix(c(1,2,3,4),2,2)) # optional 4 graphs/page 
plot(mod1)

ECM <- mean(resi^2)
ECM
