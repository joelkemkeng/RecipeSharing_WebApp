output "instance_fr_public_ip" {
  description = "Adresse IP publique de l'instance EC2 en France"
  value       = aws_instance.makeProcess-recipe-server-fr.public_ip
}

output "instance_de_public_ip" {
  description = "Adresse IP publique de l'instance EC2 en Allemagne"
  value       = aws_instance.makeProcess-recipe-server-de.public_ip
}

output "rds_fr_endpoint" {
  description = "Endpoint de la base de données RDS en France"
  value       = aws_db_instance.makeprocess-recipe-db-fr.endpoint
}

output "rds_de_endpoint" {
  description = "Endpoint de la base de données RDS en Allemagne"
  value       = aws_db_instance.makeprocess-recipe-db-de.endpoint
}

output "load_balancer_dns" {
  description = "Adresse DNS du Load Balancer"
  value       = aws_lb.makeProcess-recipe-lb.dns_name
}

