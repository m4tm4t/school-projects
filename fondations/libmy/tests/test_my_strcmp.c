#include <stdio.h>
#include <assert.h>
#include "my.h"

void test_my_strcmp()
{
  char *a;
  char *b;
  int  res;

  // positive result
  a = "foo";
  b = "bar";
  res = my_strcmp(a, b);
  assert(res == 1);

  // negative result
  a = "bar";
  b = "foo";
  res = my_strcmp(a, b);
  assert(res == -1);

  // equal result
  a = "bar";
  b = "bar";
  res = my_strcmp(a, b);
  assert(res == 0);

  // Buggy cases
  a = "--bar";
  b = "--ba";
  res = my_strcmp(a, b);
  assert(res != 0);

  a = "bar";
  b = "barrr";
  res = my_strcmp(a, b);
  assert(res != 0);
}
