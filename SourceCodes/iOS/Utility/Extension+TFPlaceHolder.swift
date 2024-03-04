//
//  Extension+TFPlaceHolder.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//
import Foundation
import UIKit
 
extension UITextField{
   @IBInspectable var placeHolderColor: UIColor? {
        get {
            return self.placeHolderColor
        }
        set {
            self.attributedPlaceholder = NSAttributedString(string:self.placeholder != nil ? self.placeholder! : "", attributes:[NSAttributedString.Key.foregroundColor: newValue!, NSAttributedString.Key.font: UIFont(name: "Roboto-Regular", size: 16) ?? 17])
        }
    }
}
