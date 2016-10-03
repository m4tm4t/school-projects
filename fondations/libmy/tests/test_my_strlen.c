#include <stdio.h>
#include <assert.h>
#include "my.h"

void test_my_strlen()
{
  assert(my_strlen("coucou !") == 8);
  assert(my_strlen("")         == 0);
}
