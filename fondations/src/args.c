/*
** args.c for fondations in /home/m4t/etna/fondations/src/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Fri Jul 10 16:01:30 2015 Mathieu Robardey
** Last update Thu Jul 23 22:15:47 2015 Mathieu Robardey
*/

#include "args.h"
#include <stdlib.h>

int parse_arguments(int argc, char * argv[], t_args *args)
{
  if (argc == 1)
    return usage_infos();

  for (int i = 1; i < argc; i++)
  {
    if (my_prefix_with("--", argv[i]))
    {
      if ((argc > i + 1) && !my_prefix_with("--", argv[i + 1]))
      {
        if (my_strcmp("--ip", argv[i]) == 0)
        {
          if (is_valid_ip(argv[i+1]) == EXIT_FAILURE)
            return usage_infos();
          args->ip = argv[i + 1];
        }
        else if (my_strcmp("--port", argv[i]) == 0)
        {
          if (is_valid_port(argv[i+1]) == EXIT_FAILURE)
            return usage_infos();
          args->port = my_getnbr(argv[i + 1]);
        }
      }
      else
        return usage_infos();
    }
  }

  return (EXIT_SUCCESS);
}

int usage_infos()
{
  my_putstr("Usage: ./fondations --ip 127.0.0.1 --port 4242\n");
  return (EXIT_FAILURE);
}

int is_valid_ip(char *str)
{
  if (my_strlen(str) > 0)
    return (EXIT_SUCCESS);
  else
    return (EXIT_FAILURE);
}

int is_valid_port(char *str)
{
  if (my_strlen(str) > 0)
    return (EXIT_SUCCESS);
  else
    return (EXIT_FAILURE);
}
