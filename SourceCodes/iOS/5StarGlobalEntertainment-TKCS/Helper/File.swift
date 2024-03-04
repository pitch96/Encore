//
//  File.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 24/03/23.
//

import Foundation
class Singleton{
    static let sharedInstance = Singleton()
    var fullName: String?
    var emaiID: String?
    var phoneNumber: String?
    var state: String?
    var zipCode: String?
    var city: String?
    var address: String?
    var addressId: Int?
}
