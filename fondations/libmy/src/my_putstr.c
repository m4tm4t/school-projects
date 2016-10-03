/*
** my_putstr.c for my_roulette in /home/m4t/etna/my_roulette/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Thu May 14 21:39:30 2015 Mathieu Robardey
** Last update Thu May 14 21:39:30 2015 Mathieu Robardey
*/

#include "my.h"

void my_putstr(char *str)
{
  int i;
  i = 0;

  while (str[ i ] != '\0')
  {
    my_putchar(str[ i ]);
    i++;
  }
}
