/*
** main.c for fondations in /home/m4t/etna/fondations/
**
** Made by robard_m
** Login   <robard_m@etna-alternance.net>
**
** Started on  Fri Jun 26 15:33:42 2015 Mathieu Robardey
** Last update Thu Jul 23 22:26:56 2015 Mathieu Robardey
*/

#include "my.h"
#include "args.h"
#include "tcp_client.h"
#include "fondation.h"

int main(int argc, char * argv[])
{
  t_args args;
  t_args *p_args = &args;

  if (parse_arguments(argc, argv, p_args) == EXIT_SUCCESS)
  {
    my_putchar('\n');
    my_putstr("Starting fondations client on ");
    my_putstr(p_args->ip);
    my_putchar(':');
    my_put_nbr(p_args->port);
    my_putchar('\n');
  }
  else
    return (EXIT_FAILURE);

  int sock;
  sock = init_connection(p_args);

  if (sock == EXIT_FAILURE)
    return (EXIT_FAILURE);

  handle_command(sock);
  close(sock);

  return (EXIT_SUCCESS);
}
