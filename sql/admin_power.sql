-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: bbq
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_power`
--

DROP TABLE IF EXISTS `admin_power`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_power` (
  `powerid` tinyint(3) NOT NULL AUTO_INCREMENT,
  `controller` varchar(15) NOT NULL,
  `action` varchar(15) NOT NULL,
  `powername` varchar(15) NOT NULL,
  PRIMARY KEY (`powerid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_power`
--

LOCK TABLES `admin_power` WRITE;
/*!40000 ALTER TABLE `admin_power` DISABLE KEYS */;
INSERT INTO `admin_power` VALUES (1,'Index','index','查看后台管理首页'),(2,'Index','welcome','查看后台管理欢迎页面'),(3,'Admin','add','新增管理员'),(4,'Comment','index','查看所有评论'),(5,'Comment','delete','删除某条评论'),(6,'Comment','status','修改评论状态'),(7,'Feedback','index','查看所有反馈'),(8,'Feedback','status','修改反馈状态'),(9,'Feedback','delete','删除某条反馈'),(10,'FeedbackType','delete','删除某种反馈类型'),(11,'FeedbackType','status','修改反馈某种反馈类型的状态'),(12,'FeedbackType','index','查看所有反馈列表'),(13,'FeedbackType','addType','新增反馈类型'),(14,'Image','getAccessToken','生成上传图片的token'),(15,'Image','createNonce','生成随机nonce'),(16,'Login','index','查看管理员登录页面'),(17,'Login','check','验证管理员登录密码'),(18,'Login','logout','管理员退出登录'),(19,'SlideImg','index','获取图片列表'),(20,'SlideImg','add','添加图片'),(21,'SlideImg','edit','编辑图片'),(22,'SlideImg','delete','删除图片'),(23,'SlideImg','status','修改图片状态'),(24,'Theme','status','修改主题状态'),(25,'Theme','delete','删除主题'),(26,'Theme','index','获取主题列表'),(27,'Theme','add','添加主题'),(28,'Theme','edit','编辑主题'),(29,'User','index','获取用户列表'),(30,'User','delete','删除用户'),(31,'User','status','修改用户状态'),(32,'Version','status','修改版本状态'),(33,'Version','delete','删除版本'),(34,'Version','index','获取版本列表'),(35,'Version','add','添加版本'),(36,'Version','edit','编辑版本');
/*!40000 ALTER TABLE `admin_power` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-29 13:15:45
