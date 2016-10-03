/*
** my_put_nbr.c for my_roulette in /home/m4t/etna/my_roulette/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Fri May 15 13:08:04 2015 Mathieu Robardey
** Last update Fri Jul 10 15:45:25 2015 Mathieu Robardey
*/

#include "my.h"

void my_put_nbr(int n)
{
  if (n < 0)
  {
    my_putchar('-');
    n *= -1; /* Multiply by -1 to get positive number */
  }

  if ((n/10) != 0)
    my_put_nbr(n / 10);

  char octal_value = ((n % 10) + 48);

  my_putchar(octal_value);
}
