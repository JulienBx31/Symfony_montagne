# Project Symfony
```CLI``` = Commande line interface  
```Doctrine``` = accès aux données  
```Controller``` = gerer les traitements  
```Twig``` = gerer l'affichage, le rendu  
```Fixtures``` = Créer de fausse données, exécutable à souhait et réutilisable par les autres
## Fonction utile  
> #### Manager:
>public function my_function(ObjectManager $manager)  
>$manager->persist($article);  
>$manager->flush();  
## Syntax twig
>Pour voir la syntax de twig [click ici](https://twig.symfony.com/doc/3.x/templates.html)
## Installer server:run
```composer require --dev symfony/web-server-dundle```
## 1. Create the project:
```composer create-project symfony/website-skeleton my_project_name "4.4.*"```  
```php bin/console make:controller``` -> créé un controller  
### L'ORM de Symfony: Doctrine  
>Entity: repésente des tables  
>Manager: permet de manipuler des lignes. Insertion/MAJ/Suppression (dans la base de donnée)  
>Repository: permet de faire des selections

## 2. Création de la base de donnée et ses sous propriétées  
```php bin/console doctrine:database:create``` -> créé une base de donnée  
```php bin/console make:entity``` -> créé une table et ses sous-propriétées  
```php bin/console make:migration``` -> permet de créer une migration SQL  
```php bin/console doctrine:migrations:migrate``` -> met à jour la base de donnée  
```composer require orm-fixtures --dev``` -> install orm-fixture afin de pouvoir créer de fausse donnée  
```php bin/console make:fixtures``` -> créé un fichier correspondant aux fausse données  
```php bin/console doctrine:fixtures:load``` -> charge toutes les fixtures dans la base

## 3. Le mode de login
> Entité USER (on a une table USER) avec les propriétées:
>>-> EMAIL  
>>-> USERNAME  
>>-> PASSWORD  

>Formulaire de connexion/register:  
```php bin/console make:form RegistrationType``` -> le formulaire est relié à l'entitée USER et qui créé le fichier RegistrationType.php  

>On créé un controller afin d'afficher le formulaire qui se nommera ```SecurityController```  
>L'objet USER est relié aux champs du formulaire (```RegistrationType::class```) 

>Dans le fichier ```Form/RegistrationType.php```:  
>>Si l'on veut rajouter un champ par ex *confirme_password*, on doit aller dans le fichier entité de USER ```Entity/User.php``` et donc rajouter le champ *confirme_password* (pas oblige de mettre @ORM, si le champ ne concerne pas la DB)  
>>  
>>Par exemple le champ: *->add('password', PasswordType::class)*. ```PasswordType::class``` nous permet de cacher les charactères tapé par des étoiles lors de l'inscription.

>Dans le fichier```Controller/SecurityController.php```:
>>En premier on a la route */inscription* qui affiche le rendu du formulaire d'inscription dans le fichier ```templates/security/registration.html.twig```  

>Dans le fichier ```Entity/User.php```:  
>>On à ajouter des **Constraints** qui va nous permettre de valider les champs (formulaire) avec -> ```use Symfony fony\Component\Validator\Constraints as Assert;```, par exemple:```@Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")```  
>>  
>>Pour rendre un email unique:  
>>Après l'ORM de l'USER class, je dois mettre ça:  
>>*@UniqueEntity(  
>>*fields={"email"},  
>>*message="L'email que vous avez indiqué est déjà utilisé"  
>>*)  

>Dans le fichier ```config/packages/security.yaml```:  
>>Pour crypter les mots de passe des **USER**, on met dans le fichier:  
>>encoders: App\Entity\User: algorithm: bcrypt  
>>>On va dans le fichier ```Controller/SecurityController.php```  
>>>$hash = $encoder->encodePassword($user, $user->getPassword());  
>>>$user->setPassword($hash);


