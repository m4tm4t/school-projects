/*
** my.h for libmy in /home/m4t/etna/libmy/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Mon Jun 29 21:09:30 2015 Mathieu Robardey
** Last update Thu Jul 23 19:40:07 2015 Mathieu Robardey
*/

#ifndef LIBMY_H
#define LIBMY_H

#include "limits.h"

void my_putchar(char c);
void my_putstr(char *str);
void my_put_nbr(int i);

int  my_getnbr(char *str);
void test_my_getnbr();

int  my_strcmp(char *s1, char *s2);
void test_my_strcmp();

int  my_strlen(char *str);
void test_my_strlen();

int  my_prefix_with(char *prefix, char *string);
void test_my_prefix_with();

void my_bzero(char *str);
void test_my_bzero();

char *readLine();

#endif /* end of include guard: LIBMY_H */
