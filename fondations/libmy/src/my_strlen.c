/*
** my_strlen.c for libmy in /home/m4t/etna/fondations/libmy/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Fri Jul 10 14:16:10 2015 Mathieu Robardey
** Last update Fri Jul 10 14:16:10 2015 Mathieu Robardey
*/

int my_strlen(char *str)
{
  int i;

  i = 0;
  while (str[i])
    i++;

  return (i);
}
