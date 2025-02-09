provider "aws" {
  region     = var.region_fr
  access_key = var.aws_access_key
  secret_key = var.aws_secret_key
}

provider "aws" {
  alias      = "aws_de"
  region     = var.region_de
  access_key = var.aws_access_key
  secret_key = var.aws_secret_key
}

