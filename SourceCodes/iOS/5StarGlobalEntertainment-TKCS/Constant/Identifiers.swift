//
//  Identifiers.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 04/01/23.
//

import Foundation
import UIKit

extension UITableViewCell {
    
    // MARK: - Returnn UITableViewCell identifier
    class var identifier : String {
        return String(describing: self)
    }
}
 
 
extension UIViewController {
    
    // MARK: - Returnn UIViewController identifier
    class var identifier: String {
        return String(describing: self)
    }
}
extension UICollectionViewCell {
    
    // MARK: - Returnn UITableViewCell identifier
    class var identifier : String {
        return String(describing: self)
    }
}
extension UITableViewHeaderFooterView{
    
    // MARK: - Returnn UITableViewCell identifier
    class var identifier : String {
        return String(describing: self)
    }
}
