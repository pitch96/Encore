//
//  SDHomeTabBarController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 23/11/22.
//

import UIKit

class FSGHomeTabBarController: UITabBarController, UITabBarControllerDelegate {
    // MARK: View Life Cycle--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        manageTabbarOption()
        delegate = self
    }
        
    // MARK: Manage tab bar with User type--
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
       
    }
   // MARK: Create private function to manage tab bar item
    private func manageTabbarOption(){
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        debugPrint(UserDefaults.standard.value(forKey:Tokenkey.UsersTypes) ?? 0)
        switch userType {
       
        case 1:
            debugPrint(UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) ?? 0)
            self.viewControllers?.remove(at: 3)
        case 2:
            debugPrint(UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) ?? 0)
            self.viewControllers?.remove(at: 4)
        case 3:
            debugPrint(UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) ?? 0)
            self.viewControllers?.remove(at: 3)
        case 0:
            tabBar.isHidden = true
            debugPrint(UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) ?? 0)
            
        default:
            break
        }
    }
    // MARK: Create a function for manage tab bar--
    ///create a function for directly move to specific tab
    func tabBarController(_ tabBarController: UITabBarController, shouldSelect viewController: UIViewController) -> Bool {
            (viewController as? UINavigationController)?.popToRootViewController(animated: true)
            return true
        }
}
