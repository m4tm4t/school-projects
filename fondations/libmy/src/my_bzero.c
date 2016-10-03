/*
** my_bzero.c for libmy in /home/m4t/etna/fondations/libmy/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Thu Jul 23 13:18:42 2015 Mathieu Robardey
** Last update Thu Jul 23 19:56:59 2015 Mathieu Robardey
*/

#include "my.h"

void my_bzero(char *str)
{
  for (int i = 0; i < my_strlen(str); i++)
  {
    str[i] = '\0';
  }
}
