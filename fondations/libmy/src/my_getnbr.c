/*
** my_getnbr.c for libmy in /home/m4t/etna/libmy/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Fri May 15 13:52:56 2015 Mathieu Robardey
** Last update Fri Jul 10 15:45:25 2015 Mathieu Robardey
*/

#include "my.h"

int my_getnbr(char *str)
{
  int res;

  res = 0;
  for (int i = 0; i < my_strlen(str); i++)
    res = res * 10 + (str[i] - '0');

  return (res);
}
