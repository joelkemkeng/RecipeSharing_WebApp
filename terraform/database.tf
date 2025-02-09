resource "aws_db_instance" "makeprocess-recipe-db-fr" {
  identifier           = "makeprocess-recipe-db-fr"
  engine               = "mysql"
  instance_class       = "db.t3.micro"
  allocated_storage    = 20
  username            = "admin"
  password            = "makeprocess"
  multi_az            = true
  storage_encrypted   = true
  skip_final_snapshot = true
}

resource "aws_db_instance" "makeprocess-recipe-db-de" {
  provider           = aws.aws_de
  identifier         = "makeprocess-recipe-db-de"
  engine            = "mysql"
  instance_class    = "db.t3.micro"
  replicate_source_db = aws_db_instance.makeprocess-recipe-db-fr.identifier
  multi_az          = true

  depends_on = [aws_db_instance.makeprocess-recipe-db-fr]
}

