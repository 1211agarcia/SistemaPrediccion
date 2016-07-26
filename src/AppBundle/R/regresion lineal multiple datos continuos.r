#Regresion lineal


#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("muestra_real.txt",header=TRUE)
data
#Nombre de columnas a ignorar para este experimento, calclulo de ignora pues es la salida deseada
drops <- c("cant_mat","escuela","gestion_plantel","tipo_plantel","nivel_socioeco","nivel_estudios_padres","genero","opsu")
#se descarta Cant_cats por tener correlacion poco significativa
data <- data[ , !(names(data) %in% drops)]
data
pairs(data)
cor(data)

y <- data[,6]
y
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
mod1 <- lm(y ~ x[,1] + x[,2] + x[,3] + x[,4] + x[,5])

summary(mod1)

# Other useful functions 
coefficients(mod1) # model coefficients
confint(mod1, level=0.95) # CIs for model parameters 
fitted(mod1) # predicted values
residuals(mod1) # residuals
anova(mod1) # anova table 
vcov(mod1) # covariance matrix for model parameters 
influence(mod1) # regression diagnostics

# diagnostic plots 
layout(matrix(c(1,2,3,4),2,2)) # optional 4 graphs/page 
plot(mod1)

ECM <- mean(residuals(mod1)^2)
ECM
