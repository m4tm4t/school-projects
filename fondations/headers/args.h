/*
** args.h for fondations in /home/m4t/etna/fondations/headers/
**
** Made by Mathieu Robardey
** Login   <robard_m@etna-alternance.net>
**
** Started on  Thu Jul  2 13:16:40 2015 Mathieu Robardey
** Last update Thu Jul 23 20:21:56 2015 Mathieu Robardey
*/

#ifndef ARGS_H
#define ARGS_H

#include "my.h"

typedef struct s_args
{
  int  port;
  char *ip;
} t_args;

int parse_arguments(int argc, char * argv[], t_args *args);

int is_valid_ip(char *str);
int is_valid_port(char *str);

int usage_infos();

#endif /* end of include guard: ARGS_H */
