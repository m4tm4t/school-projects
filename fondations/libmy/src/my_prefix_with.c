/*
** my_prefix_with.c for libmy in /home/m4t/etna/fondations/libmy/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Fri Jul 10 11:30:12 2015 Mathieu Robardey
** Last update Thu Jul 23 23:24:50 2015 Mathieu Robardey
*/

int my_prefix_with(char *prefix, char *string)
{
  while(*prefix)
  {
    if (*prefix++ != *string++)
      return 0;
  }

  return 1;
}
