/*
** my_putchar.c for my_roulette in /home/m4t/etna/my_roulette/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Thu May 14 21:48:27 2015 Mathieu Robardey
** Last update Thu May 14 21:48:27 2015 Mathieu Robardey
*/

#include <unistd.h>

void my_putchar(char c)
{
  write(1, &c, 1);
}
