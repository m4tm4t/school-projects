<?php

class UnitType extends SplEnum
{
  const QUANTITY = 1;
  const VOLUME   = 2;
  const WEIGHT   = 3;
  const LENGTH   = 4;
}

class QuantityUnit extends SplEnum
{
}

class VolumeUnit extends SplEnum
{
  const ML = 1;
  const CL = 2;
  const L  = 3;
  const TEASPOON   = 4;
  const TABLESPOON = 5;
}

class WeightUnit extends SplEnum
{
  const MG = 1;
  const G  = 2;
  const KG = 3;
}

class LengthUnit extends SplEnum
{
  const MM = 1;
  const CM = 2;
  const M  = 3;
}
