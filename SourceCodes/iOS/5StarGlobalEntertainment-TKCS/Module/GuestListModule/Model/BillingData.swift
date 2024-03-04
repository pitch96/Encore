//
//  BillingData.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 24/04/23.
//

import Foundation

// MARK: - BillingData
struct BillingData: Codable {
    var activeAddressID, fullName, phoneNo, email: String?
    var state, city, zipcode, address: String?
    
    enum CodingKeys: String, CodingKey {
        case activeAddressID = "active_address_id"
        case fullName = "full_name"
        case phoneNo = "phone_no"
        case email, state, city, zipcode, address
    }
}
