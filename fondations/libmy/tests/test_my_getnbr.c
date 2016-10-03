#include <stdio.h>
#include <assert.h>
#include "my.h"

void test_my_getnbr()
{
  assert(my_getnbr("4242") == 4242);
  assert(my_getnbr("123456789") == 123456789);
}
