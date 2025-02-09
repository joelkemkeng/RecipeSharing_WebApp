
resource "aws_key_pair" "makeprocess-recipe-key" {
  key_name   = "makeprocess-recipe-key"
  public_key = file("~/.ssh/makeprocess-recipe-key.pub")

  tags = {
    Name = "makeprocess-recipe-key"
  }
}





resource "aws_instance" "makeProcess-recipe-server-fr" {
  ami             = "ami-00983e8a26e4c9bd9"  # Ubuntu 22.04 LTS
  instance_type   = "t2.micro"
  subnet_id       = aws_subnet.makeProcess-recipe-subnet-fr.id
  vpc_security_group_ids = [aws_security_group.makeProcess-recipe-sg.id]
  associate_public_ip_address = true
  key_name        = aws_key_pair.makeprocess-recipe-key.key_name

  tags = {
    Name = "makeProcess-recipe-Server-FR"
    Project = "makeProcess-recipe"
    Region = "France"
  }
}

resource "aws_instance" "makeProcess-recipe-server-de" {
  provider        = aws.aws_de
  ami             = "ami-00983e8a26e4c9bd9"  # Ubuntu 22.04 LTS
  instance_type   = "t2.micro"
  subnet_id       = aws_subnet.makeProcess-recipe-subnet-de.id
  vpc_security_group_ids = [aws_security_group.makeProcess-recipe-sg.id]
  associate_public_ip_address = true
  key_name        = aws_key_pair.makeprocess-recipe-key.key_name

  tags = {
    Name = "makeProcess-recipe-Server-DE"
    Project = "makeProcess-recipe"
    Region = "Germany"
  }
}

