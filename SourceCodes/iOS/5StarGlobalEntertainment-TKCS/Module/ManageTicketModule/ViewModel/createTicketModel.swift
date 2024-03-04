//
//  CreateTicketModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 15/02/23.
//

import Foundation
struct CreateTicketModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: TicketDetails?
}

// MARK: - DataClass
struct TicketDetails: Codable {
    var status, message: String?
}
