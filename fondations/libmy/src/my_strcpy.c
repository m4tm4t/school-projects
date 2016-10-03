/*
** my_strcpy.c for  in /home/m4t/etna/my_roulette/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Fri May 15 10:07:53 2015 Mathieu Robardey
** Last update Fri May 15 10:07:53 2015 Mathieu Robardey
*/

/** TODO: Ask why we return something since we get it back from pointer **/

char *my_strcpy(char *dest, char *src)
{
  int i = 0;
  while (src[i])
  {
    dest[i] = src[i];
    i++;
  }
  dest[i] = '\0';

  return dest;
}
