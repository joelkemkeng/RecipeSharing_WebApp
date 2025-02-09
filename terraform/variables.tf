variable "aws_access_key" {
  description = "Clé d'accès AWS"
  type        = string
  sensitive   = true
}

variable "aws_secret_key" {
  description = "Clé secrète AWS"
  type        = string
  sensitive   = true
}

variable "region_fr" {
  description = "Région AWS pour la France"
  type        = string
  default     = "eu-west-3"
}

variable "region_de" {
  description = "Région AWS pour l'Allemagne"
  type        = string
  default     = "eu-central-1"
}
