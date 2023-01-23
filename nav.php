<?php
    // Navbar file

    if (isset($_GET['p']))	$p = $_GET['p'];	else $p = 'NULL'; 

    $a = $b = $c = $d = $e = $f = $g = $h = NULL;
    
    if ($p == 'home') { $a = 'active';}
    else if ($p == 'about') { $b = 'active';}
    else if ($p == 'donate') { $c = 'active';}
    else if ($p == 'search') { $d = 'active';}
    else if ($p == 'signin' || $p == 'guestsignin') { $e = 'active';}
    else if ($p == 'createaccount') { $f = 'active';}
    else if ($p == 'profile' || $p == 'myFoodBank' || $p == 'addEmployee') { $g = 'active';}
    else if ($p == 'signout') { $h = 'active';}

    //<li class='nav-item $c'><a class='nav-link' href='GnG.php?p=donate'> Donate</a></li>


    echo "<nav class='navbar navbar-dark navbar-expand-sm'>
    <div class='container'>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#Navbar' aria-controls='Navbar' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <a class='navbar-brand' href='GNG.php?p=home'>Give n' Get</a>
        <div class='collapse navbar-collapse' id='Navbar'>
            <ul class='navbar-nav'>
                <li class='nav-item $a'><a class='nav-link' href='GNG.php?p=home'> Home</a></li>
                <li class='nav-item $b'><a class='nav-link' href='GnG.php?p=about'> About</a></li>
                
                <li class='nav-item dropdown $d'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownSearch' role='button' data-toggle='dropdown' aria-expanded='false'> Search</a>
                    <ul class='dropdown-menu' aria-labelledby='navbarDropdownSearch'>
                        <li><a class='dropdown-item' href='GnG.php?p=search'>Search Locations</a></li>
                        <li><a class='dropdown-item' href='GnG.php?p=searchItem'>Search Items</a></li>
                    </ul>
                </li>
            </ul>";
                if (!$logon OR $p == 'signout') {
                    echo "<ul class='nav navbar-nav w-100 justify-content-end'>
                    <li class='nav-item $e'><a class='nav-link' href='GnG.php?p=signin'> Sign In</a></li>
                    
                    <li class='nav-item dropdown $f'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownCA' role='button' data-toggle='dropdown' aria-expanded='false'> Create Account</a>
                    <ul class='dropdown-menu' aria-labelledby='navbarDropdownCA'>
                        <li><a class='dropdown-item' href='GnG.php?p=createdonoraccount'>Donor Account</a></li>
                        <li><a class='dropdown-item' href='GnG.php?p=createfbaccount'>Food Bank Account</a></li>
                    </ul>
                </li>
                    </ul>
                </div>   
            </div>
        </nav>
        <div class='flex-wrapper'>";
                }
                else if ($role == "personal" OR $role == "business") {
                    echo "<ul class='nav navbar-nav w-100 justify-content-end'>
                    <li class='nav-item $g'><a class='nav-link' href='GnG.php?p=profile'> My Account</a></li>
                    <li class='nav-item $h'><a class='nav-link' href='GnG.php?p=signout'> Sign Out</a></li>
                    </ul>
                </div>   
            </div>
        </nav>
        <div class='flex-wrapper'>";
                }
                else if ($role == "manager") {
                    echo "<ul class='nav navbar-nav w-100 justify-content-end'>
                    <li class='nav-item dropdown $g'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownP' role='button' data-toggle='dropdown' aria-expanded='false'> My Account</a>
                    <ul class='dropdown-menu' aria-labelledby='navbarDropdownP'>
                        <li><a class='dropdown-item' href='GnG.php?p=profile'>Profile</a></li>
                        <li><a class='dropdown-item' href='GnG.php?p=myFoodBank'>My Food Bank</a></li>
                        <li><a class='dropdown-item' href='GnG.php?p=addEmployee'>Add Employee</a></li>
                    </ul>
                    </li>
                    <li class='nav-item $h'><a class='nav-link' href='GnG.php?p=signout'> Sign Out</a></li>
                    </ul>
                </div>   
            </div>
        </nav>
        <div class='flex-wrapper'>";
                }
                else if ($role == "employee") {
                    echo "<ul class='nav navbar-nav w-100 justify-content-end'>
                    <li class='nav-item dropdown $g'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownP' role='button' data-toggle='dropdown' aria-expanded='false'> My Account</a>
                    <ul class='dropdown-menu' aria-labelledby='navbarDropdownP'>
                        <li><a class='dropdown-item' href='GnG.php?p=profile'>Profile</a></li>
                        <li><a class='dropdown-item' href='GnG.php?p=myFoodBank'>My Food Bank</a></li>
                    </ul>
                    </li>
                    <li class='nav-item $h'><a class='nav-link' href='GnG.php?p=signout'> Sign Out</a></li>
                    </ul>
                </div>   
            </div>
        </nav>
        <div class='flex-wrapper'>";
                }
                else {
                    echo "<ul class='nav navbar-nav w-100 justify-content-end'>
                    <li class='nav-item $h'><a class='nav-link' href='GnG.php?p=signout'> Sign Out</a></li>
                    </ul>
                </div>   
            </div>
        </nav>
        <div class='flex-wrapper'>";
                }



?>