# my_rscript.R
 
#args <- commandArgs(TRUE)
 
#N <- args[1]
#x <- rnorm(N,0,1)
 
#png(filename="../../AppBundle/R/temp.png", width=500, height=500)
#hist(x, col="lightblue")
#dev.off()

#write(x, file = "data",
#      ncolumns = if(is.character(x)) 1 else 5,
#      append = FALSE, sep = " ")
# create a 2 by 5 matrix
x <- matrix(1:100, ncol = 5)

# the file data contains x, two rows, five cols
# 1 3 5 7 9 will form the first row
write(t(x))

# Writing to the "console" 'tab-delimited'
# two rows, five cols but the first row is 1 2 3 4 5
write(x, "", sep = "\t")
unlink("data") # tidy up