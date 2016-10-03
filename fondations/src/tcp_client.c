/*
** tcp_client.c for fondations in /home/m4t/etna/fondations/src/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Tue Jul 14 14:42:13 2015 Mathieu Robardey
** Last update Thu Jul 23 19:31:07 2015 Mathieu Robardey
*/

#include "my.h"
#include "tcp_client.h"

int init_connection(t_args *arguments)
{
  int sock;

  sock = socket(AF_INET, SOCK_STREAM, 0);
  if (sock == INVALID_SOCKET)
  {
    perror(__FUNCTION__);
    return (EXIT_FAILURE);
  }

  t_sockaddr_in dest;
  dest.sin_addr.s_addr = inet_addr(arguments->ip);
  dest.sin_port        = htons(arguments->port);
  dest.sin_family      = AF_INET;

  int connection;

  connection = connect(sock, (t_sockaddr *) &dest, sizeof(t_sockaddr));
  if (connection == SOCKET_ERROR)
  {
    perror(__FUNCTION__);
    return(EXIT_FAILURE);
  }

  return (sock);
}

int my_send(int sock, char * str)
{
  int result;
  result = write(sock, str, my_strlen(str));

  return (result);
}

int my_recv(int sock)
{
  char *buffer;
  int len;
  int done;

  buffer = malloc(BUFFER_SIZE);

  while ((len = read(sock, buffer, BUFFER_SIZE)) > 0)
  {
    done = handle_data(buffer);
    if (done == 1)
     return (EXIT_SUCCESS);
  }

  free(buffer);

  return (EXIT_SUCCESS);
}

int handle_data(char *buffer)
{
  for (int i = 0; i < my_strlen(buffer); i++) {
    if (buffer[i] == '\n')
    {
      my_putchar('\n');
      return (1);
    }
    if (buffer[i] == '#')
    {
      my_putchar('\n');
      continue;
    }
    my_putchar(buffer[i]);
  }

  return (EXIT_SUCCESS);
}
