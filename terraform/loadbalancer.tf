# Load Balancer
resource "aws_lb" "makeProcess-recipe-lb" {
  name               = "makeProcess-recipe-lb"
  internal           = false
  load_balancer_type = "application"
  security_groups    = [aws_security_group.makeProcess-recipe-sg.id]
  subnets           = [
    aws_subnet.makeProcess-recipe-subnet-fr.id,
    aws_subnet.makeProcess-recipe-subnet-de.id
  ]

  tags = {
    Name = "makeProcess-recipe-LoadBalancer"
  }
}

# Cible du Load Balancer (Groupes des Instances EC2)
resource "aws_lb_target_group" "makeProcess-recipe-target-group" {
  name     = "makeProcess-recipe-tg"
  port     = 80
  protocol = "HTTP"
  vpc_id   = aws_vpc.makeProcess-recipe-vpc.id

  health_check {
    path                = "/"
    interval            = 30
    timeout             = 5
    healthy_threshold   = 2
    unhealthy_threshold = 2
  }
}

# Ajout des Instances EC2 au Load Balancer
resource "aws_lb_target_group_attachment" "makeProcess-recipe-attach-fr" {
  target_group_arn = aws_lb_target_group.makeProcess-recipe-target-group.arn
  target_id        = aws_instance.makeProcess-recipe-server-fr.id
}

resource "aws_lb_target_group_attachment" "makeProcess-recipe-attach-de" {
  target_group_arn = aws_lb_target_group.makeProcess-recipe-target-group.arn
  target_id        = aws_instance.makeProcess-recipe-server-de.id
}

# Listener pour le Load Balancer
resource "aws_lb_listener" "makeProcess-recipe-listener" {
  load_balancer_arn = aws_lb.makeProcess-recipe-lb.arn
  port              = 80
  protocol          = "HTTP"

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.makeProcess-recipe-target-group.arn
  }
}
