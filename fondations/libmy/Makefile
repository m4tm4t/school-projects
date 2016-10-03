##
## Makefile for libmy in /home/m4t/etna/fondations/libmy/
##
## Made by Mathieu Robardey
## Login   <robard_m@etna-alternance.net>
##
## Started on  Fri Jul  3 14:17:18 2015 Mathieu Robardey
## Last update Thu Jul 23 19:30:19 2015 Mathieu Robardey
##

NAME=	libmy.a

CC = gcc -W -Wall -Werror
RM = rm -f

SRC = src/*.c
OBJ = *.o

libmy:	link clean

build:
	$(CC) -I. -c $(SRC)

link: build
	ar rc $(NAME) $(OBJ)
	ranlib $(NAME)

clean:
	$(RM) *.o

test: link clean
	$(CC) -o libmy_test tests/*.c -L. -I. -lmy

fclean:	clean
	$(RM) $(NAME)
