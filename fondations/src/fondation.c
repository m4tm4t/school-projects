/*
** fondation.c for fondations in /home/m4t/etna/fondations/src/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Thu Jul 23 14:21:11 2015 Mathieu Robardey
** Last update Thu Jul 23 22:25:00 2015 Mathieu Robardey
*/

#include "my.h"
#include "tcp_client.h"

int handle_command(int sock)
{
  char *cmd;

  while (1)
  {
    my_putstr("Enter command:\n");
    my_putstr("> ");

    cmd = readLine();

    if (my_strlen(cmd) > 250)
      my_putstr("Command too long (250 characters max allowed)\n");
    else if (my_strlen(cmd) > 0)
    {
      if (my_strcmp("/bye", cmd) == 0)
      {
        my_putstr("Bye bye !\n");
        close(sock);
        return (EXIT_SUCCESS);
      }

      my_send(sock, cmd);
      my_recv(sock);
    }
    my_bzero(cmd);
  }
}
