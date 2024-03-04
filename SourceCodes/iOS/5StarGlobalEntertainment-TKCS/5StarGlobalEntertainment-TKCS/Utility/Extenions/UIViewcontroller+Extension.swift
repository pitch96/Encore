//
//  UIViewcontroller+Extension.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 26/11/22.
//

import Foundation
import UIKit
extension UIViewController{
    func doNavigation<T:UIViewController>(identifier:String,controller:T.Type)->T{
            let vc = storyboard?.instantiateViewController(withIdentifier: identifier)as! T
            navigationController?.pushViewController(vc, animated: true)
            return vc
        }
     }
