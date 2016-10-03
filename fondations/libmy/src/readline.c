/*
** readline.c for libmy in /home/m4t/etna/fondations/src/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Thu Jul 23 19:28:10 2015 Mathieu Robardey
** Last update Thu Jul 23 19:28:15 2015 Mathieu Robardey
*/

#include <stdlib.h>
#include <unistd.h>

char		*readLine()
{
  size_t	ret;
  char		*buff;

  if ((buff = malloc(sizeof(*buff) * (255 + 1))) == NULL)
    return (NULL);
  if ((ret = read(0, buff, 255)) > 1)
    {
      buff[ret - 1] = '\0';
      return (buff);
    }
  buff[0] = '\0';
  return (buff);
}
