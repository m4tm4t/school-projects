/*
** tcp_client.h for fondations in /home/m4t/etna/fondations/headers/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Tue Jul 14 14:40:14 2015 Mathieu Robardey
** Last update Thu Jul 23 19:16:24 2015 Mathieu Robardey
*/

#ifndef TCP_CLIENT_H
#define TCP_CLIENT_H

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

#include <arpa/inet.h>
#include <sys/socket.h>
#include <netinet/in.h>

#include "args.h"

#define INVALID_SOCKET -1
#define SOCKET_ERROR -1
#define BUFFER_SIZE 1024

int init_connection(t_args *arguments);

int my_send(int sock, char * str);
int my_recv(int sock);

int handle_data(char *buffer);

typedef struct sockaddr_in t_sockaddr_in;
typedef struct sockaddr t_sockaddr;
typedef struct in_addr t_in_addr;

#endif /* end of include guard: TCP_CLIENT_H */
