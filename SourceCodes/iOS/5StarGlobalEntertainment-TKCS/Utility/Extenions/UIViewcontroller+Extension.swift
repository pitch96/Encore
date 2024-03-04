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
        let vc = self.storyboard?.instantiateViewController(withIdentifier: identifier) as! T
        self.navigationController?.pushViewController(vc, animated: false)
            return vc
        }
     }
extension UITextField{
    func placeholderCostomization(placeHolderText:String){
               // self.attributedPlaceholder = NSAttributedString(string: placeHolderText, attributes: [NSAttributedString.Key.foregroundColor : UIColor.gray])
            }
     
}
