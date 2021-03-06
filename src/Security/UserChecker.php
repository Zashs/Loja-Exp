<?php
namespace App\Security;

use App\Exception\AccountInactiveException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
	public function checkPreAuth(UserInterface $user)
	{
		if (!$user->getStatus()) {
			throw new AccountInactiveException('Acesso bloqueado! Contacte administrador sistema.');	
		}		
	}
	
	public function checkPostAuth(UserInterface $user)
	{
		return;
	}	
}
