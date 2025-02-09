# =========================
# 🔹 Création du VPC
# =========================
resource "aws_vpc" "makeProcess-recipe-vpc" {
  cidr_block = "10.0.0.0/16"
  enable_dns_support = true
  enable_dns_hostnames = true

  tags = {
    Name = "makeProcess-recipe-VPC"
    Project = "makeProcess-recipe"
  }
}

# =========================
# 🔹 Sous-réseaux (Subnets)
# =========================

# Sous-réseau en France (Paris)
resource "aws_subnet" "makeProcess-recipe-subnet-fr" {
  vpc_id            = aws_vpc.makeProcess-recipe-vpc.id
  cidr_block        = "10.0.1.0/24"
  availability_zone = "eu-west-3a"
  map_public_ip_on_launch = true

  tags = {
    Name = "makeProcess-recipe-Subnet-FR"
  }
}

#  Sous-réseau en Allemagne (Francfort)
resource "aws_subnet" "makeProcess-recipe-subnet-de" {
  provider          = aws.aws_de
  vpc_id            = aws_vpc.makeProcess-recipe-vpc.id
  cidr_block        = "10.0.2.0/24"
  availability_zone = "eu-central-1a"
  map_public_ip_on_launch = true

  tags = {
    Name = "makeProcess-recipe-Subnet-DE"
  }
}

# =========================
# 🔹 Passerelle Internet (Internet Gateway)
# =========================
resource "aws_internet_gateway" "makeProcess-recipe-igw" {
  vpc_id = aws_vpc.makeProcess-recipe-vpc.id

  tags = {
    Name = "makeProcess-recipe-IGW"
  }
}

# =========================
# 🔹 Table de routage
# =========================
resource "aws_route_table" "makeProcess-recipe-rtb" {
  vpc_id = aws_vpc.makeProcess-recipe-vpc.id

  tags = {
    Name = "makeProcess-recipe-RouteTable"
  }
}

# Ajout d'une route pour l'accès à Internet
resource "aws_route" "makeProcess-recipe-route" {
  route_table_id         = aws_route_table.makeProcess-recipe-rtb.id
  destination_cidr_block = "0.0.0.0/0"
  gateway_id             = aws_internet_gateway.makeProcess-recipe-igw.id
}

# Association des sous-réseaux à la table de routage
resource "aws_route_table_association" "makeProcess-recipe-rtb-fr" {
  subnet_id      = aws_subnet.makeProcess-recipe-subnet-fr.id
  route_table_id = aws_route_table.makeProcess-recipe-rtb.id
}

resource "aws_route_table_association" "makeProcess-recipe-rtb-de" {
  provider       = aws.aws_de
  subnet_id      = aws_subnet.makeProcess-recipe-subnet-de.id
  route_table_id = aws_route_table.makeProcess-recipe-rtb.id
}

# =========================
# 🔹 Groupe de Sécurité (Security Group)
# =========================
resource "aws_security_group" "makeProcess-recipe-sg" {
  vpc_id = aws_vpc.makeProcess-recipe-vpc.id
  name   = "makeProcess-recipe-sg"
  description = "Security Group for EC2 instances"

  # SSH
  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
    description = "Allow SSH access"
  }

  # HTTP
  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
    description = "Allow HTTP access"
  }

  # HTTPS
  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
    description = "Allow HTTPS access"
  }

  # Tout trafic sortant
  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
    description = "Allow all outbound traffic"
  }

  tags = {
    Name = "makeProcess-recipe-SG"
  }
}


