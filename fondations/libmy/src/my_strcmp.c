/*
** my_strcmp.c for my_roulette in /home/m4t/etna/my_roulette/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Fri May 15 09:40:28 2015 Mathieu Robardey
** Last update Fri May 15 09:40:28 2015 Mathieu Robardey
*/

int my_strcmp(char *s1, char *s2)
{
  int i;

  i = 0;
  while (s1[i] || s2[i])
  {
    if (s1[i] < s2[i])
      return (-1);
    else if (s1[i] > s2[i])
      return (1);
    i++;
  }
  return (0);
}
